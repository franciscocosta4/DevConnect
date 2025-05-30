<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;



Route::get('/', function () {
    return view('welcome');
});



//* Rotas de autenticação do Admin (Apenas Login)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Rotas PROTEGIDAS do Admin (Só Admins podem aceder)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/projects', [SearchController::class, 'index'])->name('projects.index');
    // === ROTAS DE PROJETOS ===
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
    
    // === ROTAS DE POSTS ===
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
    Route::get('/posts/{post}/edit', [AdminController::class, 'editPost'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminController::class, 'updatePost'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');
    
    // === ROTAS DE COMENTÁRIOS ===
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
    
    // === ROTAS DE USUÁRIOS ===
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/users/{user:username}', [ProfileController::class, 'public'])->name('users.profile');

    Route::get('download/{filename}', function ($filename) {
        $path = storage_path('app/private/projects/' . $filename);

        if (Storage::disk('private')->exists('projects/' . $filename)) {
            return Response::download($path);
        } else {
            abort(404);
        }
    })->name('download.project');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{slug}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{slug}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{slug}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Posts
    Route::get('/dashboard', [PostController::class, 'index'])->middleware(['verified'])->name('dashboard');
    Route::post('/dashboard', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');


    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});

require __DIR__ . '/auth.php';
