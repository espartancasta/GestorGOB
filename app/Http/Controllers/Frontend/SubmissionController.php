<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionFile;
use App\Models\User;
use App\Notifications\NewSubmissionCreatedNotification;
use App\Notifications\ReviewInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = ['pending_assignment', 'waiting_acceptance', 'in_review', 'pending_correction', 'final_review', 'completed', 'approved', 'rejected', 'revision_completed'];
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $status = in_array($status, $allowedStatuses, true) ? $status : '';

        $statistics = Submission::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'pending_assignment' THEN 1 ELSE 0 END) as pending_assignment")
            ->selectRaw("SUM(CASE WHEN status = 'in_review' THEN 1 ELSE 0 END) as in_review")
            ->selectRaw("SUM(CASE WHEN status = 'pending_correction' THEN 1 ELSE 0 END) as pending_correction")
            ->first();

        $submissions = Submission::query()
            ->with(['author', 'reviewers'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('titulo_publicacion', 'like', "%{$search}%")
                        ->orWhereHas('author', fn ($authorQuery) => $authorQuery->where('name', 'like', "%{$search}%"));
                    if (ctype_digit($search)) {
                        $query->orWhere('id', (int) $search);
                    }
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $listRoute = request()->routeIs('frontend.home') ? 'frontend.home' : 'submissions.index';

        return view('frontend.submissions.index', compact('submissions', 'statistics', 'allowedStatuses', 'search', 'status', 'listRoute'));
    }

    public function myProjects()
    {
        $submissions = Submission::with(['files', 'reviewers.reviewer'])
            ->where('author_id', Auth::id())
            ->latest()
            ->get();

        return view('submissions.mine', compact('submissions'));
    }

    public function authorCompleted()
    {
        $submissions = Submission::with(['files', 'reviewers.reviewer'])
            ->where('author_id', Auth::id())
            ->where(function ($query) {
                $query->whereIn('status', ['completed', 'approved', 'revision_completed'])
                    ->orWhereIn('estado', ['completed', 'approved', 'revision_completed', 'aprobado', 'aprobada']);
            })
            ->latest()
            ->get();

        return view('submissions.author.completed', compact('submissions'));
    }

    public function create()
    {
        return view('frontend.submissions.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != User::ROLE_AUTHOR) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'titulo_publicacion' => ['required', 'string', 'max:255'],
            'tipo_publicacion' => ['required', 'string', 'in:Artículo de investigación,Artículo de revisión,Artículo de reflexión,Reporte técnico,Otro'],
            'resumen' => ['required', 'string'],
            'palabras_clave' => ['nullable', 'json'],
            'autores' => ['required', 'string'],
            'institucion_adscripcion' => ['required', 'string', 'max:255'],
            'archivo_documento' => ['required', 'file', 'mimes:docx', 'max:10240'],
        ]);

        DB::beginTransaction();

        try {
            $palabrasClave = collect(json_decode($request->input('palabras_clave', '[]'), true) ?: [])
                ->filter(fn ($tag) => is_string($tag) && trim($tag) !== '')
                ->map(fn ($tag) => trim($tag))
                ->unique()
                ->values()
                ->all();

            $file = $request->file('archivo_documento');
            $filename = time() . '_' . Str::slug($request->titulo_publicacion) . '.docx';
            $path = $file->storeAs('submissions', $filename, 'local');

            $submission = Submission::create([
                'user_id' => Auth::id(),
                'author_id' => Auth::id(),
                'title' => $request->titulo_publicacion,
                'summary' => $request->resumen,
                'titulo_publicacion' => $request->titulo_publicacion,
                'tipo_publicacion' => $request->tipo_publicacion,
                'resumen' => $request->resumen,
                'palabras_clave' => $palabrasClave,
                'autores' => $request->autores,
                'institucion_adscripcion' => $request->institucion_adscripcion,
                'archivo_documento' => $path,
                'estado' => 'pendiente',
                'status' => 'pending_assignment',
            ]);

            SubmissionFile::create([
                'submission_id' => $submission->id,
                'uploaded_by' => Auth::id(),
                'type' => 'original_docx',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            DB::commit();

            User::whereIn('role', [User::ROLE_SECRETARY, User::ROLE_DICOVI])
                ->get()
                ->each(fn (User $user) => $user->notify(new NewSubmissionCreatedNotification($submission)));

            return back()->with('success', 'Propuesta enviada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with([
                'error' => 'Error al subir documento',
                'debug' => $e->getMessage(),
            ]);
        }
    }

    public function show(Submission $submission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No autorizado');
        }

        if ($user->role == User::ROLE_AUTHOR && $submission->author_id !== $user->id) {
            abort(403, 'No autorizado');
        }

        if (!in_array($user->role, [User::ROLE_AUTHOR, User::ROLE_SECRETARY], true)) {
            abort(403, 'No autorizado');
        }

        $submission->load(['author', 'files', 'reviewers.reviewer']);

        $originalFile = $submission->files
            ->firstWhere('type', 'original_docx');

        return view('frontend.submissions.show', compact('submission', 'originalFile'));
    }

    public function download(Submission $submission)
    {
        if (!Auth::check() || Auth::user()->role != User::ROLE_SECRETARY) {
            abort(403, 'No autorizado');
        }

        $file = SubmissionFile::where('submission_id', $submission->id)
            ->where('type', 'original_docx')
            ->firstOrFail();

        return response()->download(
            storage_path('app/' . $file->path),
            $file->original_name ?: basename($file->path)
        );
    }

    public function assign(Request $request, Submission $submission)
    {
        if (!Auth::check() || Auth::user()->role != User::ROLE_SECRETARY) {
            abort(403, 'No autorizado');
        }

        if (!in_array($submission->status, ['pending_assignment', 'waiting_acceptance'], true)) {
            return back()->with('error', 'Este documento no se puede asignar en su estado actual.');
        }

        $request->validate([
            'reviewers' => ['required', 'array', 'size:2'],
            'reviewers.*' => ['exists:users,id'],
        ]);

        if ($request->reviewers[0] == $request->reviewers[1]) {
            return back()->with('error', 'Debes seleccionar dos revisores diferentes.');
        }

        DB::beginTransaction();

        try {
            DB::table('submission_reviewers')
                ->where('submission_id', $submission->id)
                ->delete();

            $links = [];

            foreach ($request->reviewers as $reviewerId) {
                $reviewer = User::findOrFail($reviewerId);

                if ($reviewer->role != User::ROLE_REVIEWER) {
                    throw new \Exception('Usuario invalido como revisor');
                }

                $token = hash('sha256', Str::random(60) . now());

                DB::table('submission_reviewers')->insert([
                    'submission_id' => $submission->id,
                    'reviewer_id' => $reviewerId,
                    'status' => 'invited',
                    'invite_token_hash' => $token,
                    'invite_expires_at' => now()->addDays(5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $links[] = url('/review-invite/' . $token);
                $reviewer->notify(new ReviewInvitationNotification($submission, $token));
            }

            $submission->update([
                'status' => 'waiting_acceptance',
            ]);

            DB::commit();

            return back()->with([
                'success' => 'Invitacion enviada correctamente.',
                'links' => $links,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with([
                'error' => 'Error al asignar revisores',
                'debug' => $e->getMessage(),
            ]);
        }
    }

    public function pendingReviews()
    {
        if (!Auth::check() || Auth::user()->role != User::ROLE_SECRETARY) {
            abort(403);
        }

        $submissions = Submission::with('reviewers.reviewer')
            ->latest()
            ->get();

        return view('frontend.submissions.pending', compact('submissions'));
    }
}
