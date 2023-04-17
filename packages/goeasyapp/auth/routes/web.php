<?php

use Goeasyapp\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Goeasyapp\Auth\Http\Controllers\FacebookSocialiteController;
use Goeasyapp\Auth\Http\Controllers\GoogleController;
use Goeasyapp\Auth\Http\Controllers\ProfileController;
use Goeasyapp\Auth\Http\Controllers\BotManChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'customLogin'])->name('auth.login.check');
    Route::post('/custom/register', [AuthController::class, 'store'])->name('auth.login.store');
    Route::post('/signout', [AuthController::class, 'customSignout'])->name('auth.signout');
    Route::get('/signout', [AuthController::class, 'customSignout'])->name('auth.signout');
});
Route::match(['get', 'post'], '/botman', [BotManChatController::class, 'invoke'])->name('botman-chat');
Route::get('auth/facebook', [FacebookSocialiteController::class, 'redirectToFB'])->name('auth.facebook');
Route::get('callback/facebook', [FacebookSocialiteController::class, 'handleCallback']);

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('callback/google', 'handleGoogleCallback');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
