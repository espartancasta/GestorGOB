<?php

use Illuminate\Support\Facades\Route;

// 🔐 Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;

// 🌐 Frontend
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\TagController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\SubmissionController;
use App\Http\Controllers\Frontend\ReviewInviteController;
use App\Http\Controllers\Frontend\SubmissionChatController;
use App\Models\Submission;

// 📁 Upload
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| Upload
|--------------------------------------------------------------------------
*/
Route::post('/upload-file', [FileUploadController::class, 'store'])
    ->name('upload.file');

/*
|--------------------------------------------------------------------------
| Frontend público
|--------------------------------------------------------------------------
*/
Route::name('frontend.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/post/{slug}', [PostController::class, 'index'])->name('post');

    Route::post('/comment/{id}', [CommentController::class, 'index'])->name('comment');
    Route::post('/comment-reply', [CommentController::class, 'reply'])->name('comment.reply');

    Route::get('/category/{slug}', [CategoryController::class, 'index'])->name('category');
    Route::get('/user/{username}', [UserController::class, 'show'])->name('user');
    Route::get('/tag/{name}', [TagController::class, 'index'])->name('tag');
    Route::get('/page/{slug}', [PageController::class, 'index'])->name('page');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::name('auth.')->group(function () {

    Route::get('/signup', [SignupController::class, 'index'])->name('signup');
    Route::post('/signup', [SignupController::class, 'signup'])->name('signup.submit');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::post('/logout', [LogoutController::class, 'index'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🔥 SUBMISSIONS - DETALLE COMPARTIDO AUTOR / SECRETARIO
|--------------------------------------------------------------------------
| Esta ruta permite abrir:
| /submissions/{id}
|
| Se deja fuera de role:1 y role:3 para evitar rutas duplicadas.
| La validación fina debe estar en SubmissionController@show:
| - Autor: solo sus documentos
| - Secretario: todos los documentos
| - Revisor: no debe entrar
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {

        Route::get('/{submission}', [SubmissionController::class, 'show'])
            ->whereNumber('submission')
            ->name('show');

    });

/*
|--------------------------------------------------------------------------
| 🔥 SUBMISSIONS - AUTOR (ROLE 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {

        Route::get('/create', [SubmissionController::class, 'create'])
            ->name('create');

        Route::post('/', [SubmissionController::class, 'store'])
            ->name('store');

    });

Route::middleware(['auth', 'role:1'])
    ->get('/mis-proyectos', [SubmissionController::class, 'myProjects'])
    ->name('submissions.mine');

Route::middleware(['auth', 'role:1'])
    ->get('/convocatorias', [SubmissionController::class, 'myProjects'])
    ->name('author.convocations');

Route::middleware(['auth', 'role:1'])
    ->get('/mis-propuestas/en-proceso', [SearchController::class, 'index'])
    ->name('author.submissions.in_process');

Route::middleware(['auth', 'role:1'])
    ->get('/mis-propuestas/completadas', [SubmissionController::class, 'authorCompleted'])
    ->name('author.submissions.completed');

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UserProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/perfil/editar', [UserProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/perfil', [UserProfileController::class, 'update'])
        ->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| 🔥 SUBMISSIONS - SECRETARIO (ROLE 3)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:3'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {

        Route::get('/', [SubmissionController::class, 'index'])
            ->name('index');

        Route::get('/{submission}/download', [SubmissionController::class, 'download'])
            ->whereNumber('submission')
            ->name('download');

        Route::post('/{submission}/assign', [SubmissionController::class, 'assign'])
            ->whereNumber('submission')
            ->name('assign');

    });

/*
|--------------------------------------------------------------------------
| 🔥 REVIEW INVITE - REVISOR (ROLE 2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:2'])
    ->prefix('review-invite')
    ->name('review.')
    ->group(function () {

        // 👉 LISTA DE INVITACIONES
        Route::get('/my', [ReviewInviteController::class, 'myInvitations'])
            ->name('invites');

        // 👉 VER INVITACIÓN
        Route::get('/{token}', [ReviewInviteController::class, 'show'])
            ->name('show');

        // 👉 ACEPTAR INVITACIÓN
        Route::post('/{token}/accept', [ReviewInviteController::class, 'accept'])
            ->name('accept');

        // 👉 RECHAZAR INVITACIÓN
        Route::post('/{token}/reject', [ReviewInviteController::class, 'reject'])
            ->name('reject');

        Route::get('/{token}/download-original', [ReviewInviteController::class, 'downloadOriginal'])
            ->name('downloadOriginal');

        // 👉 SUBIR REVISIÓN
        Route::post('/{token}/upload-review', [ReviewInviteController::class, 'uploadReview'])
            ->name('uploadReview');

    });

/*
|--------------------------------------------------------------------------
| 🔥 SEMANA 13 — PROBLEMAS DE REVISIÓN (SECRETARIO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:3'])
    ->get('/submissions-pending', [SubmissionController::class, 'pendingReviews'])
    ->name('submissions.pending');

Route::middleware(['auth'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {

        Route::get('/{submission}/chat', [SubmissionChatController::class, 'index'])
            ->whereNumber('submission')
            ->name('chat.index');

        Route::get('/{submission}/chat/messages', [SubmissionChatController::class, 'messages'])
            ->whereNumber('submission')
            ->name('chat.messages');

        Route::post('/{submission}/chat/messages', [SubmissionChatController::class, 'store'])
            ->whereNumber('submission')
            ->name('chat.store');

    });

/*
|--------------------------------------------------------------------------
| Mensajes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/messages', function () {
    $user = auth()->user();

    $submissions = Submission::query()
        ->with(['author', 'chatThread.messages.user'])
        ->when($user->role == 1, fn ($query) => $query->where('author_id', $user->id))
        ->when($user->role == 2, fn ($query) => $query->whereHas('reviewers', fn ($reviewers) => $reviewers->where('reviewer_id', $user->id)))
        ->latest()
        ->get();

    return view('messages.index', compact('submissions'));
})->name('messages.index');

/*
|--------------------------------------------------------------------------
| Dashboard redirect
|--------------------------------------------------------------------------
*/
Route::prefix('/dashboard')->group(function () {
    Route::any('{any?}', function () {
        return redirect()->route('frontend.home');
    })->where('any', '.*');
});
