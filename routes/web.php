<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Firebase authentication
Route::post('/api/auth/firebase-login', [AuthController::class, 'loginWithFirebase']);

// Dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // User dashboard APIs
    Route::get('/api/get-tasks', [DashboardController::class, 'getUserTasks']);
    Route::post('/api/tasks/{taskId}/complete', [DashboardController::class, 'markTaskCompleted']);
    
    // Admin APIs
    Route::prefix('api/admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'getStats']);
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/tasks', [AdminController::class, 'getTasks']);
        Route::post('/tasks', [AdminController::class, 'createTask']);
        Route::put('/tasks/{taskId}', [AdminController::class, 'updateTask']);
        Route::delete('/tasks/{taskId}', [AdminController::class, 'deleteTask']);
        Route::put('/users/{userId}/role', [AdminController::class, 'updateUserRole']);
    });
});
