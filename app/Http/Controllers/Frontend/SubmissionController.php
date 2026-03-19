<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\User;
use App\Notifications\NewSubmissionCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    /**
     * Semana 7
     * Listado de documentos pendientes de asignación
     */
    public function index()
    {
        $submissions = Submission::with('author')
            ->where('status', 'pending_assignment')
            ->latest()
            ->get();

        return view('frontend.submissions.index', compact('submissions'));
    }

    /**
     * Semana 7 (mejora)
     * Ver detalle del documento
     */
    public function show(Submission $submission)
    {
        $submission->load('author');

        $originalFile = DB::table('submission_files')
            ->where('submission_id', $submission->id)
            ->where('type', 'original_docx')
            ->latest()
            ->first();

        return view('frontend.submissions.show', compact('submission', 'originalFile'));
    }

    /**
     * Semana 7 (mejora)
     * Descargar archivo original
     */
    public function download(Submission $submission)
    {
        $file = DB::table('submission_files')
            ->where('submission_id', $submission->id)
            ->where('type', 'original_docx')
            ->latest()
            ->first();

        if (!$file) {
            abort(404, 'No se encontró el archivo del documento.');
        }

        if (!Storage::exists($file->path)) {
            abort(404, 'El archivo no existe en el almacenamiento.');
        }

        return Storage::download($file->path);
    }

    /**
     * Semana 5
     * Mostrar formulario de envío
     */
    public function create()
    {
        return view('frontend.submissions.create');
    }

    /**
     * Semana 6
     * Guardar documento enviado por el autor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'file'    => ['required', 'file', 'mimes:docx', 'max:10240'],
        ], [
            'file.mimes' => 'El archivo debe estar en formato Word (.docx).',
        ]);

        DB::beginTransaction();

        try {
            // 1) Insertar submission
            $submissionId = DB::table('submissions')->insertGetId([
                'author_id'   => Auth::id(),
                'title'       => $validated['title'],
                'summary'     => $validated['summary'],
                'status'      => 'pending_assignment',
                'final_notes' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // 2) Guardar archivo
            $file = $request->file('file');

            $folder = "private/submissions/{$submissionId}";
            $filename = 'original_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folder, $filename);

            // 3) Insertar en submission_files
            DB::table('submission_files')->insert([
                'submission_id' => $submissionId,
                'uploaded_by'   => Auth::id(),
                'type'          => 'original_docx',
                'path'          => $path,
                'mime'          => $file->getClientMimeType(),
                'size'          => $file->getSize(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // 4) Notificar
            $recipients = User::whereIn('role', [
                User::IS_ADMIN,
            ])->get();

            if ($recipients->isNotEmpty()) {
                Notification::send(
                    $recipients,
                    new NewSubmissionCreatedNotification(
                        (object) [
                            'id'     => $submissionId,
                            'title'  => $validated['title'],
                            'status' => 'pending_assignment',
                            'author' => (object) ['name' => Auth::user()->name],
                        ]
                    )
                );
            }

            DB::commit();

            return redirect()
                ->route('submissions.create')
                ->with('success', 'Documento enviado correctamente. Quedó en estado: Pendiente de asignación.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al enviar el documento.');
        }
    }
}