<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SubmissionReviewer;
use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewInviteController extends Controller
{
    /**
     * 👁️ Ver invitación
     */
    public function show($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with('submission')
            ->first();

        if (!$invite) {
            abort(404, 'Invitación no válida');
        }

        // 🔐 Solo el revisor asignado
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }

        // ⏰ Expiración
        if ($invite->invite_expires_at && now()->greaterThan($invite->invite_expires_at)) {

            if ($invite->status !== 'expired') {
                $invite->update(['status' => 'expired']);
            }

            return view('frontend.review-invite.show', [
                'invite' => $invite,
                'expired' => true
            ]);
        }

        return view('frontend.review-invite.show', [
            'invite' => $invite,
            'expired' => false
        ]);
    }

    /**
     * ❌ Rechazar invitación
     */
    public function reject($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404);
        }

        // 🔐 Seguridad
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403);
        }

        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitación ya no es válida.');
        }

        $invite->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()->route('frontend.home')
            ->with('success', 'Has rechazado la revisión.');
    }

    /**
     * ✅ Aceptar invitación
     */
    public function accept($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404);
        }

        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403);
        }

        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitación ya no es válida.');
        }

        DB::beginTransaction();

        try {

            $invite->update([
                'status' => 'accepted',
                'accepted_at' => now()
            ]);

            Submission::where('id', $invite->submission_id)
                ->update(['status' => 'in_review']);

            DB::commit();

            return redirect()->route('frontend.home')
                ->with('success', 'Has aceptado la revisión correctamente 🔥');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error', 'Error al aceptar la revisión');
        }
    }

    /**
     * 📋 LISTA DE INVITACIONES (MIS INVITACIONES)
     */
    public function myInvitations()
    {
        $invites = SubmissionReviewer::where('reviewer_id', auth()->id())
            ->with('submission')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.review-invite.my', compact('invites'));
    }

    /**
     * 📤 Subir revisión
     */
    public function uploadReview(Request $request, $token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404);
        }

        // 🔐 Seguridad
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403);
        }

        // 🚫 Solo si aceptó
        if ($invite->status !== 'accepted') {
            return back()->with('error', 'Debes aceptar la revisión primero.');
        }

        // ✅ Validación
        $request->validate([
            'file' => ['required', 'file', 'mimes:docx', 'max:10240']
        ]);

        DB::beginTransaction();

        try {

            $file = $request->file('file');

            $filename = time().'_review_'.$invite->submission_id.'.docx';

            $path = $file->storeAs('submissions', $filename, 'local');

            // 📎 Guardar archivo
            SubmissionFile::create([
                'submission_id' => $invite->submission_id,
                'uploaded_by'   => Auth::id(),
                'type'          => 'review_docx',
                'path'          => $path,
                'mime'          => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);

            // 🔁 Actualizar estado del reviewer
            $invite->update([
                'status' => 'completed',
                'review_uploaded_at' => now()
            ]);

            DB::commit();

            return back()->with('success', 'Revisión subida correctamente 🔥');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error', 'Error al subir la revisión');
        }
    }
}