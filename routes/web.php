<?php

use App\Models\Post;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\PreventGetRequests;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CommentController;

// API Route pre vylistovanie postov
Route::get('/api/posts', function () {
    return response()->json(Post::all());
});

//Route na stahovanie suborov
Route::get("export", function() {

    $filepath = storage_path("app/output.csv");
    $data = Post::all()->toArray();

    $output = fopen($filepath, "w");
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);

    //Storage::put("file.txt", "content of a file");

    // Vrátime súbor na stiahnutie
    return response()->download($filepath);
});


Route::get('/', [AuthController::class, 'showRegistrationForm'])->name('register')->middleware(CheckAuthenticated::class);

Route::get('/', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create'])->name('posts.create')->middleware(CheckAuthenticated::class);
Route::post('/post', [PostController::class, 'store'])->name('posts.store')->middleware(CheckAuthenticated::class);
//Route::get('/post/{id}', [PostController::class, 'show'])->where('id', '[0-9]+')->middleware(CheckAuthenticated::class);
Route::get('/post/{id}', [PostController::class, 'show'])->name('posts.show')->middleware(CheckAuthenticated::class);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(PreventGetRequests::class);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected Route
Route::get('/dashboard', function () {
    return 'Dashboard';
})->middleware(CheckAuthenticated::class);

// Tag routes
Route::get('/tags', [TagController::class, 'index'])->middleware('auth');
Route::get('/tag/{id}', [TagController::class, 'show'])->middleware('auth');

// User routes
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');;

Route::get('post/{id}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware(CheckAuthenticated::class);
Route::put('post/{id}', [PostController::class, 'update'])->name('posts.update')->middleware(CheckAuthenticated::class);

Route::get('post/{id}/delete', [PostController::class, 'delete'])->name('posts.delete.confirm')->middleware(CheckAuthenticated::class);
Route::delete('post/{id}', [PostController::class, 'destroy'])->name('posts.delete')->middleware(CheckAuthenticated::class);
Route::get('/user/{id}/posts', [UserController::class, 'userPosts'])->name('user.posts')->middleware(CheckAuthenticated::class);

Route::get('auth/{service}', [AuthController::class, 'redirectToProvider']);
Route::get('auth/{service}/callback', [AuthController::class, 'handleProviderCallback']);

Route::get('download/{file}', [FileController::class, 'download'])->name('files.download');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');

Route::post('/post/{id}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('/user/{id}/remove-profile-image', [UserController::class, 'removeProfileImage'])->name('user.removeProfileImage');



Route::get('/admin', function () {
    return 'Admin Dashboard';
})->middleware(['auth', 'admin']);





