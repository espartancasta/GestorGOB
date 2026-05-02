<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    /**
     * 📋 Lista de documentos (SECRETARIO)
     */
    public function index()
    {
        $submissions = Submission::latest()->get();
        return view('frontend.submissions.index', compact('submissions'));
    }

    /**
     * 📝 Formulario (AUTOR)
     */
    public function create()
    {
        return view('frontend.submissions.create');
    }

    /**
     * 🔥 GUARDAR DOCUMENTO (AUTOR)
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'file'    => ['required', 'file', 'mimes:docx', 'max:10240'],
        ]);

        DB::beginTransaction();

        try {

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($request->title) . '.docx';
            $path = $file->storeAs('submissions', $filename, 'local');

            $submission = Submission::create([
                'author_id' => Auth::id(),
                'title'     => $request->title,
                'summary'   => $request->summary,
                'status'    => 'pending_assignment',
            ]);

            SubmissionFile::create([
                'submission_id' => $submission->id,
                'uploaded_by'   => Auth::id(),
                'type'          => 'original_docx',
                'path'          => $path,
                'mime'          => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);

            DB::commit();

            return back()->with('success', 'Documento enviado correctamente 🚀');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with([
                'error' => 'Error al subir documento',
                'debug' => $e->getMessage()
            ]);
        }
    }

    /**
     * 👁️ Ver detalle
     */
    public function show(Submission $submission)
    {
        $originalFile = SubmissionFile::where('submission_id', $submission->id)
            ->where('type', 'original_docx')
            ->first();

        return view('frontend.submissions.show', compact('submission', 'originalFile'));
    }

    /**
     * 📥 Descargar archivo
     */
    public function download(Submission $submission)
    {
        $file = SubmissionFile::where('submission_id', $submission->id)
            ->where('type', 'original_docx')
            ->firstOrFail();

        return response()->download(
            storage_path('app/' . $file->path)
        );
    }

    /**
     * 👥 ASIGNAR REVISORES
     */
    public function assign(Request $request, Submission $submission)
{
    if (!Auth::check() || Auth::user()->role != 3) {
        abort(403, 'No autorizado');
    }

    if ($submission->status !== 'pending_assignment') {
        return back()->with('error', 'Este documento ya fue asignado');
    }

    $request->validate([
        'reviewers' => ['required', 'array', 'size:2'],
        'reviewers.*' => ['exists:users,id']
    ]);

    if ($request->reviewers[0] == $request->reviewers[1]) {
        return back()->with('error', 'Debes seleccionar dos revisores diferentes');
    }

    DB::beginTransaction();

    try {

        DB::table('submission_reviewers')
            ->where('submission_id', $submission->id)
            ->delete();

        $links = [];

        foreach ($request->reviewers as $reviewerId) {

            $user = User::findOrFail($reviewerId);

            if ($user->role != 2) {
                throw new \Exception('Usuario inválido como revisor');
            }

            // 🔥 TOKEN PRO SEGURO
            $token = hash('sha256', Str::random(60) . now());

            DB::table('submission_reviewers')->insert([
                'submission_id'      => $submission->id,
                'reviewer_id'        => $reviewerId,
                'status'             => 'invited',
                'invite_token_hash'  => $token,
                'invite_expires_at'  => now()->addDays(5),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            $links[] = url('/review-invite/' . $token);
        }

        $submission->update([
            'status' => 'waiting_acceptance'
        ]);

        DB::commit();

        return back()->with([
            'success' => '✔ Invitación enviada correctamente 🔥',
            'links' => $links
        ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()->with([
            'error' => 'Error al asignar revisores',
            'debug' => $e->getMessage()
        ]);
    }
}

    /**
     * 🔥 SEMANA 13 — VER PROBLEMAS DE REVISIÓN
     */
    public function pendingReviews()
    {
        if (!Auth::check() || Auth::user()->role != 3) {
            abort(403);
        }

        $submissions = Submission::with('reviewers')->latest()->get();

        return view('frontend.submissions.pending', compact('submissions'));
    }
}