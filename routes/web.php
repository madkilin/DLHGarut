<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// end Registrasi
// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
// end Login
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// end Logout
// Email Verif
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Buat view ini
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Verifikasi email

    return redirect('/dashboard'); // Redirect setelah verifikasi
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link verifikasi telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// end Email Verif
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', fn() => view('welcome'));
});
Route::post('/laporan', [ReportController::class, 'submitReport'])->middleware('auth')->name('laporan.submit');
