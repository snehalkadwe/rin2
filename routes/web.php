<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        // User management routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
        Route::get('/impersonation/leave', [UserController::class, 'leaveImpersonation'])->name('impersonate.leave');
    });

    // Notifications
    Route::resource('notifications', NotificationController::class);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // User settings
    Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
    Route::put('/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');
});

require __DIR__ . '/auth.php';
