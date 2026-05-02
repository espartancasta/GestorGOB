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
use App\Http\Controllers\Frontend\SubmissionController;
use App\Http\Controllers\Frontend\ReviewInviteController;

// 📁 Upload
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| Upload
|--------------------------------------------------------------------------
*/
Route::post('/upload-file', [FileUploadController::class, 'store'])->name('upload.file');

/*
|--------------------------------------------------------------------------
| Frontend público
|--------------------------------------------------------------------------
*/
Route::name('frontend.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/post/{slug}', [PostController::class, 'show'])->name('post');

    Route::post('/comment/{id}', [CommentController::class, 'index'])->name('comment');
    Route::post('/comment-reply', [CommentController::class, 'reply'])->name('comment.reply');

    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category');
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
| 🔥 SUBMISSIONS - AUTOR (ROLE 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])
    ->prefix('submissions')
    ->name('submissions.')
    ->group(function () {

        Route::get('/create', [SubmissionController::class, 'create'])->name('create');
        Route::post('/', [SubmissionController::class, 'store'])->name('store');
        Route::get('/{submission}', [SubmissionController::class, 'show'])->name('show');
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

        Route::get('/', [SubmissionController::class, 'index'])->name('index');
        Route::get('/{submission}', [SubmissionController::class, 'show'])->name('show');
        Route::get('/{submission}/download', [SubmissionController::class, 'download'])->name('download');
        Route::post('/{submission}/assign', [SubmissionController::class, 'assign'])->name('assign');
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
        Route::get('/{token}', [ReviewInviteController::class, 'show']);

        // 👉 ACCIONES
        Route::post('/{token}/accept', [ReviewInviteController::class, 'accept']);
        Route::post('/{token}/reject', [ReviewInviteController::class, 'reject']);
        Route::post('/{token}/upload-review', [ReviewInviteController::class, 'uploadReview']);
});

/*
|--------------------------------------------------------------------------
| 🔥 SEMANA 13 — PROBLEMAS DE REVISIÓN (SECRETARIO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:3'])
    ->get('/submissions-pending', [SubmissionController::class, 'pendingReviews'])
    ->name('submissions.pending');

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