<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Tutor\TutorProfileController;
use App\Http\Controllers\Tutor\TutorDashboardController;
use App\Http\Controllers\Tutor\TutorPostController;
use App\Http\Controllers\Tutor\TutorApplicationController;
use App\Http\Controllers\Tutor\TutorTuitionController;
use App\Http\Controllers\Tutor\TutorSettingsController;
use App\Http\Controllers\Guardian\GuardianProfileController;
use App\Http\Controllers\Guardian\GuardianDashboardController;
use App\Http\Controllers\Guardian\GuardianPostController;
use App\Http\Controllers\Guardian\GuardianApplicationController;
use App\Http\Controllers\Guardian\GuardianTuitionController;
use App\Http\Controllers\Guardian\GuardianTutorController;
use App\Http\Controllers\Partner\PartnerProfileController;
use App\Http\Controllers\Partner\PartnerDashboardController;
use App\Http\Controllers\Partner\PartnerPostController;
use App\Http\Controllers\Partner\PartnerEarningsController;
use App\Http\Controllers\Partner\PartnerPayoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileApprovalController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\TuitionVerificationController;
use App\Http\Controllers\Admin\CommissionApprovalController;
use App\Http\Controllers\Admin\PayoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home/Landing Page - Test route without sessions
Route::get('/', function () {
    return response('Laravel Application is Running! Database: ' . config('database.default'));
})->name('home')->withoutMiddleware([
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \App\Http\Middleware\EncryptCookies::class,
]);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Login, Register)
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Email Verification
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

/*
|--------------------------------------------------------------------------
| Profile Status Pages
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/pending', function () {
        return view('profile.pending');
    })->name('profile.pending');

    Route::get('/profile/rejected', function () {
        return view('profile.rejected');
    })->name('profile.rejected');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'user.type:1,2']) // Super Admin & Admin
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Approvals
        Route::get('/profiles', [ProfileApprovalController::class, 'index'])->name('profiles.index');
        Route::get('/profiles/{id}', [ProfileApprovalController::class, 'show'])->name('profiles.show');
        Route::post('/profiles/{id}/approve', [ProfileApprovalController::class, 'approve'])->name('profiles.approve');
        Route::post('/profiles/{id}/reject', [ProfileApprovalController::class, 'reject'])->name('profiles.reject');
        
        // User Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserManagementController::class, 'show'])->name('users.show');
        Route::post('/users/{id}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
        Route::post('/users/{id}/unsuspend', [UserManagementController::class, 'unsuspend'])->name('users.unsuspend');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        
        // Tuition Verification
        Route::get('/tuitions', [TuitionVerificationController::class, 'index'])->name('tuitions.index');
        Route::get('/tuitions/{id}', [TuitionVerificationController::class, 'show'])->name('tuitions.show');
        Route::post('/tuitions/{id}/verify', [TuitionVerificationController::class, 'verify'])->name('tuitions.verify');
        Route::post('/tuitions/{id}/reject', [TuitionVerificationController::class, 'reject'])->name('tuitions.reject');
        
        // Commission Approvals
        Route::get('/commissions', [CommissionApprovalController::class, 'index'])->name('commissions.index');
        Route::get('/commissions/{id}', [CommissionApprovalController::class, 'show'])->name('commissions.show');
        Route::post('/commissions/{id}/approve', [CommissionApprovalController::class, 'approve'])->name('commissions.approve');
        Route::post('/commissions/{id}/reject', [CommissionApprovalController::class, 'reject'])->name('commissions.reject');
        
        // Payout Management
        Route::get('/payouts', [PayoutController::class, 'index'])->name('payouts.index');
        Route::get('/payouts/{id}', [PayoutController::class, 'show'])->name('payouts.show');
        Route::post('/payouts/{id}/approve', [PayoutController::class, 'approve'])->name('payouts.approve');
        Route::post('/payouts/{id}/process', [PayoutController::class, 'process'])->name('payouts.process');
        Route::post('/payouts/{id}/complete', [PayoutController::class, 'complete'])->name('payouts.complete');
        Route::post('/payouts/{id}/reject', [PayoutController::class, 'reject'])->name('payouts.reject');
    });

/*
|--------------------------------------------------------------------------
| Tutor Routes
|--------------------------------------------------------------------------
*/
Route::prefix('tutor')
    ->name('tutor.')
    ->middleware(['auth', 'verified', 'user.type:3']) // Tutor only
    ->group(function () {
        // Profile Creation (allow if not complete)
        Route::get('/profile/create', [TutorProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile/step1', [TutorProfileController::class, 'storeStep1'])->name('profile.store-step1');
        Route::get('/profile/step2', [TutorProfileController::class, 'createStep2'])->name('profile.create-step2');
        Route::post('/profile/step2', [TutorProfileController::class, 'storeStep2'])->name('profile.store-step2');
        Route::get('/profile/step3', [TutorProfileController::class, 'createStep3'])->name('profile.create-step3');
        Route::post('/profile/qualification', [TutorProfileController::class, 'storeQualification'])->name('profile.store-qualification');
        Route::delete('/profile/qualification/{id}', [TutorProfileController::class, 'deleteQualification'])->name('profile.delete-qualification');
        Route::post('/profile/step4', [TutorProfileController::class, 'continueToStep4'])->name('profile.continue-step4');
        Route::get('/profile/step4', [TutorProfileController::class, 'createStep4'])->name('profile.create-step4');
        Route::post('/profile/document', [TutorProfileController::class, 'storeDocument'])->name('profile.store-document');
        Route::delete('/profile/document/{id}', [TutorProfileController::class, 'deleteDocument'])->name('profile.delete-document');
        Route::post('/profile/submit', [TutorProfileController::class, 'submitProfile'])->name('profile.submit');

        // Dashboard and other routes (require profile complete & approved)
        Route::middleware(['profile.complete', 'profile.approved'])->group(function () {
            Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');
            Route::get('/profile/edit', [TutorProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [TutorProfileController::class, 'update'])->name('profile.update');
            Route::get('/posts', [TutorPostController::class, 'index'])->name('posts.index');
            Route::get('/posts/{id}', [TutorPostController::class, 'show'])->name('posts.show');
            Route::get('/applications', [TutorApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/{id}', [TutorApplicationController::class, 'show'])->name('applications.show');
            Route::post('/applications', [TutorApplicationController::class, 'store'])->name('applications.store');
            Route::delete('/applications/{id}', [TutorApplicationController::class, 'destroy'])->name('applications.destroy');
            Route::get('/tuitions', [TutorTuitionController::class, 'index'])->name('tuitions.index');
            Route::get('/tuitions/{id}', [TutorTuitionController::class, 'show'])->name('tuitions.show');
            Route::post('/tuitions/{id}/confirm', [TutorTuitionController::class, 'confirm'])->name('tuitions.confirm');
            Route::post('/tuitions/{id}/mark-completed', [TutorTuitionController::class, 'markCompleted'])->name('tuitions.mark-completed');
            Route::get('/settings', [TutorSettingsController::class, 'index'])->name('settings.index');
            Route::put('/settings/account', [TutorSettingsController::class, 'updateAccount'])->name('settings.account');
            Route::put('/settings/password', [TutorSettingsController::class, 'updatePassword'])->name('settings.password');
        });
    });

/*
|--------------------------------------------------------------------------
| Guardian Routes
|--------------------------------------------------------------------------
*/
Route::prefix('guardian')
    ->name('guardian.')
    ->middleware(['auth', 'verified', 'user.type:4']) // Guardian only
    ->group(function () {
        // Profile Creation
        Route::get('/profile/create', [GuardianProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile', [GuardianProfileController::class, 'store'])->name('profile.store');

        // Dashboard and other routes
        Route::middleware(['profile.complete', 'profile.approved'])->group(function () {
            Route::get('/dashboard', [GuardianDashboardController::class, 'index'])->name('dashboard');
            Route::get('/profile/edit', [GuardianProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [GuardianProfileController::class, 'update'])->name('profile.update');
            Route::get('/posts', [GuardianPostController::class, 'index'])->name('posts.index');
            Route::get('/posts/create', [GuardianPostController::class, 'create'])->name('posts.create');
            Route::post('/posts', [GuardianPostController::class, 'store'])->name('posts.store');
            Route::get('/posts/{id}', [GuardianPostController::class, 'show'])->name('posts.show');
            Route::get('/posts/{id}/edit', [GuardianPostController::class, 'edit'])->name('posts.edit');
            Route::put('/posts/{id}', [GuardianPostController::class, 'update'])->name('posts.update');
            Route::delete('/posts/{id}', [GuardianPostController::class, 'destroy'])->name('posts.destroy');
            Route::get('/applications', [GuardianApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/{id}', [GuardianApplicationController::class, 'show'])->name('applications.show');
            Route::post('/applications/{id}/shortlist', [GuardianApplicationController::class, 'shortlist'])->name('applications.shortlist');
            Route::post('/applications/{id}/accept', [GuardianApplicationController::class, 'accept'])->name('applications.accept');
            Route::post('/applications/{id}/reject', [GuardianApplicationController::class, 'reject'])->name('applications.reject');
            Route::get('/tuitions', [GuardianTuitionController::class, 'index'])->name('tuitions.index');
            Route::get('/tuitions/{id}', [GuardianTuitionController::class, 'show'])->name('tuitions.show');
            Route::post('/tuitions/{id}/confirm', [GuardianTuitionController::class, 'confirm'])->name('tuitions.confirm');
            Route::post('/tuitions/{id}/complete', [GuardianTuitionController::class, 'complete'])->name('tuitions.complete');
            Route::get('/tuitions/{id}/review', [GuardianTuitionController::class, 'reviewForm'])->name('tuitions.review-form');
            Route::post('/tuitions/{id}/review', [GuardianTuitionController::class, 'storeReview'])->name('tuitions.review');
            Route::get('/tutors', [GuardianTutorController::class, 'index'])->name('tutors.index');
            Route::get('/tutors/{id}', [GuardianTutorController::class, 'show'])->name('tutors.show');
        });
    });

/*
|--------------------------------------------------------------------------
| Partner Routes
|--------------------------------------------------------------------------
*/
Route::prefix('partner')
    ->name('partner.')
    ->middleware(['auth', 'verified', 'user.type:5']) // Partner only
    ->group(function () {
        // Profile Creation
        Route::get('/profile/create', [PartnerProfileController::class, 'create'])->name('profile.create');
        Route::post('/profile', [PartnerProfileController::class, 'store'])->name('profile.store');

        // Dashboard and other routes
        Route::middleware(['profile.complete', 'profile.approved'])->group(function () {
            Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
            Route::get('/profile/edit', [PartnerProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [PartnerProfileController::class, 'update'])->name('profile.update');
            Route::get('/posts', [PartnerPostController::class, 'index'])->name('posts.index');
            Route::get('/posts/create', [PartnerPostController::class, 'create'])->name('posts.create');
            Route::post('/posts', [PartnerPostController::class, 'store'])->name('posts.store');
            Route::get('/posts/{id}', [PartnerPostController::class, 'show'])->name('posts.show');
            Route::get('/posts/{id}/edit', [PartnerPostController::class, 'edit'])->name('posts.edit');
            Route::put('/posts/{id}', [PartnerPostController::class, 'update'])->name('posts.update');
            Route::delete('/posts/{id}', [PartnerPostController::class, 'destroy'])->name('posts.destroy');
            Route::get('/earnings', [PartnerEarningsController::class, 'index'])->name('earnings.index');
            Route::get('/earnings/{id}', [PartnerEarningsController::class, 'show'])->name('earnings.show');
            Route::get('/payouts', [PartnerPayoutController::class, 'index'])->name('payouts.index');
            Route::get('/payouts/create', [PartnerPayoutController::class, 'create'])->name('payouts.create');
            Route::post('/payouts', [PartnerPayoutController::class, 'store'])->name('payouts.store');
            Route::get('/payouts/{id}', [PartnerPayoutController::class, 'show'])->name('payouts.show');
        });
    });
