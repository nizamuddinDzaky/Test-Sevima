<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostingController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('register');
})->name('register-page')->middleware('guest');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::middleware(['auth'])->group(function() {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('explore', [HomeController::class, 'explore'])->name('explore');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('update-profile', [HomeController::class, 'updateProfile'])->name('update-profile');
    Route::post('update-profile', [HomeController::class, 'updateProfileSave'])->name('update-profile-post');

    Route::prefix('posting')->group(function () {
        Route::get('add', [PostingController::class, 'add'])->name('posting.add');
        Route::post('add', [PostingController::class, 'store'])->name('posting.store');
        Route::get('like/{posting_id}', [PostingController::class, 'like'])->name('posting.like');
        Route::get('dislike/{posting_id}', [PostingController::class, 'dislike'])->name('posting.dislike');
        Route::get('preview-image/{posting_id}', [PostingController::class, 'previewImage'])->name('posting.preview-image');
        Route::get('comment/{posting_id}', [PostingController::class, 'comment'])->name('posting.comment');
        Route::post('comment/{posting_id}', [PostingController::class, 'commentSave'])->name('posting.comment.post');
    });
});
