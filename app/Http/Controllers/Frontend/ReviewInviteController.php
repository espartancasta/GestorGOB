<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;
use App\Models\User;
use App\Notifications\ReviewProblemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewInviteController extends Controller
{
    public function show($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with(['submission.author'])
            ->first();

        if (!$invite) {
            abort(404, 'Invitacion no valida');
        }

        $this->authorizeReviewer($invite);

        if ($invite->status === 'invited' && $invite->isExpired()) {
            $invite->update(['status' => 'expired']);
            $this->notifySecretaries($invite, 'expired');

            return view('frontend.review-invite.show', [
                'invite' => $invite->fresh(['submission.author']),
                'expired' => true,
            ]);
        }

        return view('frontend.review-invite.show', [
            'invite' => $invite,
            'expired' => false,
        ]);
    }

    public function reject($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with('submission')
            ->first();

        if (!$invite) {
            abort(404, 'Invitacion no encontrada');
        }

        $this->authorizeReviewer($invite);

        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitacion ya no es valida.');
        }

        if ($invite->isExpired()) {
            $invite->update(['status' => 'expired']);
            $this->notifySecretaries($invite, 'expired');

            return back()->with('error', 'Esta invitacion ya expiro.');
        }

        $invite->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        $this->notifySecretaries($invite, 'rejected');

        return redirect()
            ->route('frontend.home')
            ->with('success', 'Has rechazado la revision.');
    }

    public function accept($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404, 'Invitacion no encontrada');
        }

        $this->authorizeReviewer($invite);

        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitacion ya no es valida.');
        }

        if ($invite->isExpired()) {
            $invite->update(['status' => 'expired']);
            $this->notifySecretaries($invite, 'expired');

            return back()->with('error', 'Esta invitacion ya expiro.');
        }

        DB::beginTransaction();

        try {
            $invite->update([
                'status' => 'accepted',
                'accepted_at' => now(),
                'review_due_at' => now()->addDays(5),
            ]);

            Submission::where('id', $invite->submission_id)
                ->update(['status' => 'in_review']);

            DB::commit();

            return redirect()
                ->route('review.show', $token)
                ->with('success', 'Has aceptado la revision correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al aceptar la revision.');
        }
    }

    public function myInvitations()
    {
        $invites = SubmissionReviewer::where('reviewer_id', Auth::id())
            ->with(['submission.author'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.review-invite.my', compact('invites'));
    }

    public function downloadOriginal($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with('submission')
            ->first();

        if (!$invite) {
            abort(404, 'Invitacion no encontrada');
        }

        $this->authorizeReviewer($invite);

        if (!in_array($invite->status, ['accepted', 'completed'], true)) {
            abort(403, 'Debes aceptar la invitacion antes de descargar el documento.');
        }

        $file = SubmissionFile::where('submission_id', $invite->submission_id)
            ->where('type', 'original_docx')
            ->firstOrFail();

        return response()->download(
            storage_path('app/' . $file->path),
            $file->original_name ?: basename($file->path)
        );
    }

    public function uploadReview(Request $request, $token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with('submission')
            ->first();

        if (!$invite) {
            abort(404, 'Invitacion no encontrada');
        }

        $this->authorizeReviewer($invite);

        if ($invite->status !== 'accepted') {
            return back()->with('error', 'Debes aceptar la revision primero.');
        }

        if ($invite->isReviewDueExpired()) {
            return back()->with('error', 'La fecha limite para subir esta revision ya vencio.');
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:docx', 'max:10240'],
        ], [
            'file.required' => 'Debes seleccionar un archivo.',
            'file.file' => 'El archivo no es valido.',
            'file.mimes' => 'El archivo debe ser formato .docx.',
            'file.max' => 'El archivo no debe pesar mas de 10 MB.',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file');
            $filename = time() . '_review_' . $invite->submission_id . '_reviewer_' . Auth::id() . '.docx';
            $path = $file->storeAs('submissions', $filename, 'local');

            SubmissionFile::create([
                'submission_id' => $invite->submission_id,
                'uploaded_by' => Auth::id(),
                'type' => 'review_docx',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            $invite->update([
                'status' => 'completed',
                'review_uploaded_at' => now(),
            ]);

            $completedReviews = SubmissionReviewer::where('submission_id', $invite->submission_id)
                ->where('status', 'completed')
                ->count();

            if ($completedReviews >= 2) {
                Submission::where('id', $invite->submission_id)
                    ->update(['status' => 'pending_correction']);
            }

            DB::commit();

            return back()->with('success', 'Revision subida correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al subir la revision.');
        }
    }

    private function authorizeReviewer(SubmissionReviewer $invite): void
    {
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }
    }

    private function notifySecretaries(SubmissionReviewer $invite, string $reason): void
    {
        User::where('role', User::ROLE_SECRETARY)
            ->get()
            ->each(fn (User $user) => $user->notify(new ReviewProblemNotification($invite, $reason)));
    }
}
