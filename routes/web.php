<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::redirect('/', 'posts');

Route::resource('posts', PostController::class);


Route::middleware('auth') -> group(function(){

    Route::get('/dashboard', [DashboardController::class, 'index']) -> middleware('verified') -> name('dashboard'); 

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])-> middleware('verified')-> name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    //Email verification notice route
    Route::get('/email/verify', [AuthController:: class, 'verifyNotice'])->name('verification.notice');

    //Email verification handler route
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');

    //resending the verification email
    Route::post('/email/verification-notification',[AuthController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');


        // Route for displaying the edit form
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

        // Route for updating the post after editing
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    
        // Route for deleting the post
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});



Route::middleware('guest') -> group(function (){

    Route::view('/signup', 'auth.signup')->name('signup');

    Route::post('/signup', [AuthController::class, 'signup']); 
    
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
});