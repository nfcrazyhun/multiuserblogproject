<?php

use App\Http\Controllers\Admin\AdminPostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Guest routes
 */
//Home
Route::get('/', \App\Http\Livewire\Posts::class)->name('home');

//user+posts
Route::prefix('/user')->name('user.')->group( function () {
    Route::get('/', function () { return redirect()->route('home'); });

    Route::get('{user:username}', \App\Http\Livewire\UserPosts::class)->name('posts.index');
    Route::get('{user:username}/posts/{post:slug}', \App\Http\Livewire\ShowPost::class)->name('posts.show');
});

//--------------------------------------------------------------------------

/**
 * Authenticated routes
 */
Route::prefix('/admin')->name('admin.')->middleware('auth')->group( function () {
    //Dashboard
    Route::get('/', function () { return redirect()->route('admin.dashboard'); });
    Route::get('dashboard', function () { return view('dashboard'); })->name('dashboard');

    //My Posts
    Route::get('/posts', \App\Http\Livewire\Admin\IndexPosts::class)->name('posts.index');

});

/**
 * Superadmin section
 */
Route::prefix('/superadmin')->name('superadmin.')->middleware('auth')->group( function () {
    Route::get('/', function () { return redirect()->route('superadmin.posts.index'); });

    //All Posts
    Route::get('/posts', \App\Http\Livewire\Admin\SuperAdminPosts::class)->name('posts.index');
});

Route::middleware('auth')->group( function () {
    //Profile
    Route::get('profile', \App\Http\Livewire\Profile::class)->name('profile.edit');
});

//--------------------------------------------------------------------------
require __DIR__.'/auth.php';
