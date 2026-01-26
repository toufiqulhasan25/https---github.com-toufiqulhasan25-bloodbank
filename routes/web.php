<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonorSearchController;

/* =======================
    PUBLIC ROUTES
======================= */

// ল্যান্ডিং পেজ
Route::get('/', function () {
    return view('landing');
});

// রক্ত খোঁজার পেজ (Find Blood) - এখানে কন্ট্রোলার ব্যবহার করা হয়েছে
Route::get('/find-blood', [DonorSearchController::class, 'index'])->name('find.blood');

// রক্তদানের তথ্য (Donate)
Route::get('/donate-info', function () {
    return view('donate-info');
});

// হাসপাতালের তথ্য (Hospitals)
Route::get('/hospitals-info', function () {
    return view('hospitals-info');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/* =======================
    AUTHENTICATED ROUTES (Role Based)
======================= */
Route::middleware(['auth'])->group(function () {

    // --- DONOR ROUTES (Donor) ---
    Route::middleware('role:donor')->prefix('donor')->group(function () {
        Route::get('/dashboard', [DonorController::class, 'index']); 
        Route::get('/appointment', [AppointmentController::class, 'create']);
        Route::post('/appointment', [AppointmentController::class, 'store']);
        Route::get('/history', [DonorController::class, 'history']);
    });

    // --- HOSPITAL ROUTES ---
    Route::middleware('role:hospital')->prefix('hospital')->group(function () {
        Route::get('/dashboard', [HospitalController::class, 'index']);
        Route::get('/request', [BloodRequestController::class, 'create']);
        Route::post('/request', [BloodRequestController::class, 'store']);
    });

    // --- MANAGER ROUTES ---
    Route::middleware('role:manager')->prefix('manager')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'index']);
        Route::get('/inventory', [ManagerController::class, 'inventory']);
        Route::post('/inventory', [InventoryController::class, 'store']);
        Route::get('/expiry-alerts', [InventoryController::class, 'expiryAlerts']);
        Route::get('/requests', [BloodRequestController::class, 'manage']);
        Route::post('/requests/approve/{id}', [BloodRequestController::class, 'approve']);
        Route::post('/requests/reject/{id}', [BloodRequestController::class, 'reject']);
        Route::get('/appointments', [AppointmentController::class, 'manage']);
        Route::post('/appointments/approve/{id}', [AppointmentController::class, 'approve']);
        Route::get('/reports', [ManagerController::class, 'reports']);
    });
});