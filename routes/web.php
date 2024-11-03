<?php

use App\Http\Controllers\BlogPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/register');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('posts', BlogPostController::class)->middleware('auth');