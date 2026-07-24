<?php

use Illuminate\Support\Facades\Route;

// Ã°Å¸â€Â Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;

// Ã°Å¸Å’Â Frontend
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

// Ã°Å¸â€œÂ Upload
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
| Frontend pÃƒÂºblico
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
| Ã°Å¸â€Â¥ SUBMISSIONS - DETALLE COMPARTIDO AUTOR / SECRETARIO
|--------------------------------------------------------------------------
| Esta ruta permite abrir:
| /submissions/{id}
|
| Se deja fuera de role:1 y role:3 para evitar rutas duplicadas.
| La validaciÃƒÂ³n fina debe estar en SubmissionController@show:
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
| Ã°Å¸â€Â¥ SUBMISSIONS - AUTOR (ROLE 1)
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
| Ã°Å¸â€Â¥ SUBMISSIONS - SECRETARIO (ROLE 3)
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
| Ã°Å¸â€Â¥ REVIEW INVITE - REVISOR (ROLE 2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:2'])
    ->prefix('review-invite')
    ->name('review.')
    ->group(function () {

        // Ã°Å¸â€˜â€° LISTA DE INVITACIONES
        Route::get('/my', [ReviewInviteController::class, 'myInvitations'])
            ->name('invites');

        // Ã°Å¸â€˜â€° VER INVITACIÃƒâ€œN
        Route::get('/{token}', [ReviewInviteController::class, 'show'])
            ->name('show');

        // Ã°Å¸â€˜â€° ACEPTAR INVITACIÃƒâ€œN
        Route::post('/{token}/accept', [ReviewInviteController::class, 'accept'])
            ->name('accept');

        // Ã°Å¸â€˜â€° RECHAZAR INVITACIÃƒâ€œN
        Route::post('/{token}/reject', [ReviewInviteController::class, 'reject'])
            ->name('reject');

        Route::get('/{token}/download-original', [ReviewInviteController::class, 'downloadOriginal'])
            ->name('downloadOriginal');

        // Ã°Å¸â€˜â€° SUBIR REVISIÃƒâ€œN
        Route::post('/{token}/upload-review', [ReviewInviteController::class, 'uploadReview'])
            ->name('uploadReview');

    });

/*
|--------------------------------------------------------------------------
| Ã°Å¸â€Â¥ SEMANA 13 Ã¢â‚¬â€ PROBLEMAS DE REVISIÃƒâ€œN (SECRETARIO)
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

    if ($user->role === \App\Models\User::ROLE_SECRETARY) {
        $search = trim((string) request('q', ''));
        $filter = in_array(request('filter'), ['recent', 'empty', 'pending'], true)
            ? request('filter')
            : 'all';
        $recentSince = now()->subDays(7);

        $baseQuery = Submission::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('titulo_publicacion', 'like', "%{$search}%")
                        ->orWhereHas('author', fn ($author) => $author->where('name', 'like', "%{$search}%"));
                    if (ctype_digit($search)) {
                        $query->orWhere('id', (int) $search);
                    }
                });
            });

        $filterCounts = [
            'all' => (clone $baseQuery)->count(),
            'recent' => (clone $baseQuery)->whereHas('chatThread.messages', fn ($messages) => $messages->where('created_at', '>=', $recentSince))->count(),
            'empty' => (clone $baseQuery)->whereDoesntHave('chatThread.messages')->count(),
            'pending' => (clone $baseQuery)->whereHas('chatThread.latestMessage', fn ($message) => $message->where('user_id', '!=', $user->id))->count(),
        ];

        $submissions = $baseQuery
            ->with(['author', 'chatThread.latestMessage.user'])
            ->when($filter === 'recent', fn ($query) => $query->whereHas('chatThread.messages', fn ($messages) => $messages->where('created_at', '>=', $recentSince)))
            ->when($filter === 'empty', fn ($query) => $query->whereDoesntHave('chatThread.messages'))
            ->when($filter === 'pending', fn ($query) => $query->whereHas('chatThread.latestMessage', fn ($message) => $message->where('user_id', '!=', $user->id)))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('messages.secretary', compact('submissions', 'search', 'filter', 'filterCounts'));
    }

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
