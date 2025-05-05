    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProjectController;
    use App\Http\Controllers\PostController;
    use App\Http\Controllers\CommentController;

    Route::get('/', function () {
        return view('welcome');
    });



    Route::middleware('auth')->group(function () {
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


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
