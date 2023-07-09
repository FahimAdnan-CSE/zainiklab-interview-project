<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Routing\Middleware\ThrottleRequests;

// Auth routes
Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/login', [UserController::class, 'login']);


// Admin routes
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/users', [AdminController::class, 'showUserList'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'removeUser'])->name('admin.removeUser');
    Route::put('/admin/users/{id}/{status}', [AdminController::class, 'disableUser'])->name('admin.disableUser');
});


// Customer routes
Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});
Route::get('/customer/profile/{id}', [CustomerController::class, 'profile'])->name('customer.profile');




Route::post('/login', [UserController::class, 'login'])
    ->name('login')
    ->middleware(
        ThrottleRequests::class.':3,15', // Block for 15 minutes after 3 login attempts
        ThrottleRequests::class.':6,45' // Block for 45 minutes after 6 login attempts
    );

    // Route::post('/login', [UserController::class, 'login'])
    // ->name('login');
