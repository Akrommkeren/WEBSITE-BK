<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/post', [DashboardController::class, 'storePost'])->name('post.store');
    
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/editprofile', function () {
        return view('editprofile');
    })->name('editprofile');

    Route::get('/group', function () {
        return view('group');
    })->name('group');

    Route::get('/layanan', function () {
        return view('layanan');
    })->name('layanan');

    Route::get('/progres', function () {
        return view('progres');
    })->name('progres');

    // Managerial Routes (Staff only)
    Route::middleware(['can:is-staff'])->prefix('management')->name('management.')->group(function () {
        Route::get('/admin', [ManagementController::class, 'adminIndex'])->name('admin');
        Route::post('/admin/project', [ManagementController::class, 'storeProject'])->name('admin.project.store');
        Route::patch('/admin/project/{project}/status', [ManagementController::class, 'updateProjectStatus'])->name('admin.project.status');
        
        Route::get('/web-developer', [ManagementController::class, 'webDevIndex'])->name('web_dev');
        Route::get('/designer', [ManagementController::class, 'designerIndex'])->name('designer');
        
        Route::patch('/project/{project}/progress', [ManagementController::class, 'updateProgress'])->name('project.progress');
    });
});
