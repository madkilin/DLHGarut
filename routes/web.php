<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PetugasComplaintController;
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
Route::put('/admin/users/{id}/updateStatus', [UserController::class, 'updateStatus'])->name('users.updateStatus');
Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('admin.complaints.index');
Route::get('/complaints/{id}/show', [AdminComplaintController::class, 'show'])->name('admin.complaints.show');
Route::put('/complaints/{id}/status', [AdminComplaintController::class, 'updateStatus'])->name('admin.complaints.updateStatus');
Route::put('/admin/complaints/{id}/assign', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assign');
Route::post('/complaints/{id}/assign-task', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assignTask');
Route::get('/admin/complaints/{id}/print', [AdminComplaintController::class, 'print'])->name('admin.complaints.print');
// complaint petugas
Route::get('/petugas/complaints', [PetugasComplaintController::class, 'index'])->name('petugas.complaints.index');
Route::get('/petugas/complaints/{id}', [PetugasComplaintController::class, 'show'])->name('petugas.complaints.show');

Route::get('/petugas/complaints/{id}/proof', [PetugasComplaintController::class, 'proof'])->name('petugas.complaints.proof');
Route::get('/petugas/complaints/proof/{id}', [\App\Http\Controllers\User\ProofController::class, 'create'])->name('petugas.proof.create');
Route::post('/petugas/complaints/proof/{id}', [\App\Http\Controllers\User\ProofController::class, 'store'])->name('petugas.proof.store');
Route::get('/petugas/proofs/{id}', [\App\Http\Controllers\User\ProofController::class, 'show'])->name('petugas.proof.show');
Route::get('/admin/complaints/print/complete/{id}', [AdminComplaintController::class, 'printComplete'])->name('admin.complaints.print.complete');
Route::get('/admin/complaints/print/proof/{id}', [AdminComplaintController::class, 'printProof'])->name('admin.complaints.print.proof');
