<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' =>['web','auth']], function(){

    Route::get('/', [App\Http\Controllers\AlbumController::class, 'index']);
    Route::get('/albums', [App\Http\Controllers\AlbumController::class, 'index']);
    Route::get('/albums/{id}', [App\Http\Controllers\AlbumController::class, 'show'])->name('album-show');

    Route::post('/albums/store', [App\Http\Controllers\AlbumController::class, 'store'])->name('album-store');
    Route::post('/posts', [App\Http\Controllers\PostsController::class, 'store'])->name('posts.store');
    Route::post('/posts/like', [App\Http\Controllers\LikeController::class, 'postlike'])->name('postlike');
    Route::post('comment/{post}', [App\Http\Controllers\CommentController::class, 'postComment'])->name('addComment');

    Route::delete('/posts/{id}', [App\Http\Controllers\PostsController::class, 'destroy'])->name('post-destroy');
    Route::get('/post-edit/{id}', [App\Http\Controllers\PostsController::class, 'edit'])->name('post-edit');
    Route::put('/post-update/{id}', [App\Http\Controllers\PostsController::class, 'update'])->name('post-update');

});

Route::get('/', [App\Http\Controllers\AlbumController::class, 'index']);
Route::get('/albums/{id}', [App\Http\Controllers\AlbumController::class, 'show'])->name('album-show');