<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\SubmissionReviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReviewInviteController extends Controller
{
    /**
     * 👁️ Ver invitación
     */
    public function show($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with(['submission.author'])
            ->first();

        if (!$invite) {
            abort(404, 'Invitación no válida');
        }

        // 🔐 Solo el revisor asignado puede ver esta invitación
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }

        /*
        |--------------------------------------------------------------------------
        | Expiración de invitación
        |--------------------------------------------------------------------------
        | La invitación solo debe expirar mientras está en estado "invited".
        | Si ya fue aceptada, rechazada o completada, no debe cambiarse a expired.
        */
        if (
            $invite->status === 'invited' &&
            $invite->invite_expires_at &&
            now()->greaterThan($invite->invite_expires_at)
        ) {
            $invite->update([
                'status' => 'expired'
            ]);

            return view('frontend.review-invite.show', [
                'invite' => $invite->fresh(['submission.author']),
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
            abort(404, 'Invitación no encontrada');
        }

        // 🔐 Solo el revisor asignado puede rechazar
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }

        // Solo se puede rechazar si todavía está invitado
        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitación ya no es válida.');
        }

        // Si ya expiró, no se permite rechazar
        if ($invite->invite_expires_at && now()->greaterThan($invite->invite_expires_at)) {
            $invite->update([
                'status' => 'expired'
            ]);

            return back()->with('error', 'Esta invitación ya expiró.');
        }

        $invite->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()
            ->route('frontend.home')
            ->with('success', 'Has rechazado la revisión.');
    }

    /**
     * ✅ Aceptar invitación
     *
     * Semana 14:
     * - Cambia status a accepted.
     * - Guarda accepted_at.
     * - Guarda review_due_at = 5 días después de aceptar.
     * - Cambia la submission a in_review.
     */
    public function accept($token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)->first();

        if (!$invite) {
            abort(404, 'Invitación no encontrada');
        }

        // 🔐 Solo el revisor asignado puede aceptar
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }

        // Solo se puede aceptar si está en invited
        if ($invite->status !== 'invited') {
            return back()->with('error', 'Esta invitación ya no es válida.');
        }

        // Si ya expiró, no se permite aceptar
        if ($invite->invite_expires_at && now()->greaterThan($invite->invite_expires_at)) {
            $invite->update([
                'status' => 'expired'
            ]);

            return back()->with('error', 'Esta invitación ya expiró.');
        }

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Datos de aceptación
            |--------------------------------------------------------------------------
            | review_due_at se agrega solo si la columna existe.
            | Esto evita romper el sistema si todavía no has creado la migración.
            | Pero para cerrar Semana 14 formalmente, SÍ debes crear esa columna.
            */
            $acceptData = [
                'status' => 'accepted',
                'accepted_at' => now(),
            ];

            if (Schema::hasColumn('submission_reviewers', 'review_due_at')) {
                $acceptData['review_due_at'] = now()->addDays(5);
            }

            $invite->update($acceptData);

            Submission::where('id', $invite->submission_id)
                ->update([
                    'status' => 'in_review'
                ]);

            DB::commit();

            return redirect()
                ->route('frontend.home')
                ->with('success', 'Has aceptado la revisión correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al aceptar la revisión.');
        }
    }

    /**
     * 📋 Lista de invitaciones del revisor
     */
    public function myInvitations()
    {
        $invites = SubmissionReviewer::where('reviewer_id', Auth::id())
            ->with(['submission.author'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.review-invite.my', compact('invites'));
    }

    /**
     * 📤 Subir revisión
     *
     * El revisor sube su archivo .docx con observaciones.
     */
    public function uploadReview(Request $request, $token)
    {
        $invite = SubmissionReviewer::where('invite_token_hash', $token)
            ->with('submission')
            ->first();

        if (!$invite) {
            abort(404, 'Invitación no encontrada');
        }

        // 🔐 Solo el revisor asignado puede subir revisión
        if (!Auth::check() || Auth::id() !== (int) $invite->reviewer_id) {
            abort(403, 'No autorizado');
        }

        // Solo puede subir revisión si aceptó
        if ($invite->status !== 'accepted') {
            return back()->with('error', 'Debes aceptar la revisión primero.');
        }

        /*
        |--------------------------------------------------------------------------
        | Validación de fecha límite de revisión
        |--------------------------------------------------------------------------
        | Si existe review_due_at y ya venció, no se permite subir la revisión.
        */
        if (
            Schema::hasColumn('submission_reviewers', 'review_due_at') &&
            $invite->review_due_at &&
            now()->greaterThan($invite->review_due_at)
        ) {
            return back()->with('error', 'La fecha límite para subir esta revisión ya venció.');
        }

        // ✅ Validación del archivo
        $request->validate([
            'file' => ['required', 'file', 'mimes:docx', 'max:10240']
        ], [
            'file.required' => 'Debes seleccionar un archivo.',
            'file.file' => 'El archivo no es válido.',
            'file.mimes' => 'El archivo debe ser formato .docx.',
            'file.max' => 'El archivo no debe pesar más de 10 MB.',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file');

            $filename = time() . '_review_' . $invite->submission_id . '_reviewer_' . Auth::id() . '.docx';

            /*
            |--------------------------------------------------------------------------
            | Guardado del archivo
            |--------------------------------------------------------------------------
            | Se mantiene "local" para no romper tu configuración actual.
            | Ruta resultante:
            | storage/app/submissions/archivo.docx
            */
            $path = $file->storeAs('submissions', $filename, 'local');

            SubmissionFile::create([
                'submission_id' => $invite->submission_id,
                'uploaded_by'   => Auth::id(),
                'type'          => 'review_docx',
                'path'          => $path,
                'mime'          => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);

            // Marcar esta revisión como completada
            $invite->update([
                'status' => 'completed',
                'review_uploaded_at' => now()
            ]);

            /*
            |--------------------------------------------------------------------------
            | Adelanto del flujo
            |--------------------------------------------------------------------------
            | Si los 2 revisores ya subieron revisión, el documento pasa a:
            | pending_correction
            |
            | Esto no rompe Semana 14; más bien deja preparado el cierre de revisión.
            */
            $completedReviews = SubmissionReviewer::where('submission_id', $invite->submission_id)
                ->where('status', 'completed')
                ->count();

            if ($completedReviews >= 2) {
                Submission::where('id', $invite->submission_id)
                    ->update([
                        'status' => 'pending_correction'
                    ]);
            }

            DB::commit();

            return back()->with('success', 'Revisión subida correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Error al subir la revisión.');
        }
    }
}