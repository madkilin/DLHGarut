<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\ComplaintController;
use App\Http\Controllers\User\ProfileController;
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
    Route::get('/article', fn() => view('article'));
    Route::get('/profile', fn() => view('user.profile'))->name('user.profile');
    Route::get('/complaint', fn() => view('user.complaint'));
    // Untuk POST
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');
    // routes/web.php
    Route::get('complaints/history', [ComplaintController::class, 'history'])->name('complaints.history');
    Route::get('complaints/{id}', [ComplaintController::class, 'show'])->name('complaints.show');
});
Route::post('/laporan', [ReportController::class, 'submitReport'])->middleware('auth')->name('laporan.submit');
Route::get('/', fn() => view('landingPage'));
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/', fn() => view('landingPage'));
Route::resource('/admin/users', UserController::class);
Route::post('/admin/users/{id}/updateStatus', [UserController::class, 'updateStatus'])->name('users.updateStatus');
 Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('admin.complaints.index');
Route::put('/complaints/{id}/status', [AdminComplaintController::class, 'updateStatus'])->name('admin.complaints.updateStatus');
Route::put('/admin/complaints/{id}/assign', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assign');
Route::get('/proof/{id}/create', [\App\Http\Controllers\User\ProofController::class, 'create'])->name('proof.create');
    Route::post('/proof/{id}', [\App\Http\Controllers\User\ProofController::class, 'store'])->name('proof.store');
    Route::post('/complaints/{id}/assign-task', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assignTask');