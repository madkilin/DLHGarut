<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Petugas\ComplaintController as PetugasComplaintController;
use App\Http\Controllers\Petugas\ProofController as PetugasProofController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\ArticleController as PetugasArticleController;
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
// Laporan Pengguna
Route::post('/laporan', [ReportController::class, 'submitReport'])->middleware('auth')->name('laporan.submit');

// Landing Page
Route::get('/', fn() => view('landingPage'));

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin: Manajemen User
Route::resource('/admin/users', UserController::class);
Route::put('/admin/users/{id}/update-status', [UserController::class, 'updateStatus'])->name('users.updateStatus');

// Admin: Complaint Management
Route::get('/admin/complaints', [AdminComplaintController::class, 'index'])->name('admin.complaints.index');
Route::get('/admin/complaints/{id}/show', [AdminComplaintController::class, 'show'])->name('admin.complaints.show');
Route::put('/admin/complaints/{id}/status', [AdminComplaintController::class, 'updateStatus'])->name('admin.complaints.updateStatus');
Route::put('/admin/complaints/{id}/assign', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assign');
Route::post('/admin/complaints/{id}/assign-task', [AdminComplaintController::class, 'assignTask'])->name('admin.complaints.assignTask');

// Admin: Print Surat
Route::get('/admin/complaints/{id}/print', [AdminComplaintController::class, 'print'])->name('admin.complaints.print');
Route::get('/admin/complaints/{id}/print-complete', [AdminComplaintController::class, 'printComplete'])->name('admin.complaints.print.complete');
Route::get('/admin/complaints/{id}/print-proof', [AdminComplaintController::class, 'printProof'])->name('admin.complaints.print.proof');
Route::get('/admin/complaints/{id}/print-assignment', [AdminComplaintController::class, 'printAssigmentLetter'])->name('admin.complaints.print.assigments');

// Admin: Lihat Bukti
Route::get('/admin/complaints/{id}/show-proof', [AdminComplaintController::class, 'showProof'])->name('admin.complaints.show.proof');

// Petugas Dashboard
Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');

// Petugas: Complaint
Route::get('/petugas/complaints', [PetugasComplaintController::class, 'index'])->name('petugas.complaints.index');
Route::get('/petugas/complaints/{id}', [PetugasComplaintController::class, 'show'])->name('petugas.complaints.show');
Route::get('/petugas/complaints/{id}/proof', [PetugasComplaintController::class, 'proof'])->name('petugas.complaints.proof');

// Petugas: Proof
Route::get('/petugas/proofs/{id}/create', [PetugasProofController::class, 'create'])->name('petugas.proof.create');
Route::post('/petugas/proofs/{id}', [PetugasProofController::class, 'store'])->name('petugas.proof.store');
Route::get('/petugas/proofs/{id}', [PetugasProofController::class, 'show'])->name('petugas.proof.show');
// end Petugas
// artikel
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::post('/artikel/{article}/reward', [ArticleController::class, 'reward'])->middleware('auth')->name('artikel.reward');
Route::middleware('auth')->group(function () {
    Route::get('/artikel/{article}/reward/check', [ArticleController::class, 'checkRewardStatus'])->name('artikel.reward.check');
    Route::post('/artikel/{article}/reward/claim', [ArticleController::class, 'claimReward'])->name('artikel.reward.claim');
});
// Route untuk Admin
Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::resource('articles', AdminArticleController::class);
    });

// Route untuk Petugas
Route::prefix('petugas')
    ->as('petugas.')
    ->group(function () {
        Route::resource('articles', PetugasArticleController::class);
    });
