<?php

use App\Http\Controllers\Donor\DashboardController;
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
        Route::post('/donor/update-date', [DashboardController::class, 'updateDonationDate'])->name('donor.update.date');
        Route::get('/appointment', [AppointmentController::class, 'create']);
        Route::post('/appointment', [AppointmentController::class, 'store']);
        Route::get('/history', [DonorController::class, 'history']);
    });

    // --- HOSPITAL ROUTES ---
    // --- HOSPITAL ROUTES ---
    // --- HOSPITAL ROUTES ---
    Route::middleware('role:hospital')->prefix('hospital')->group(function () {
        // আগের কোড:
// Route::get('/dashboard', [HospitalController::class, 'index']); 

        // পরিবর্তন করে এটি লিখুন:
        Route::get('/dashboard', [HospitalController::class, 'dashboard'])->name('hospital.dashboard');
        Route::get('/request', [BloodRequestController::class, 'create'])->name('hospital.request.create');
        Route::post('/request', [BloodRequestController::class, 'store'])->name('hospital.request.store');
        Route::post('/hospital/mark-notifications-read', [HospitalController::class, 'markRead'])->name('hospital.markRead');

        // আমি এখানে রাউটটি ঠিক করে দিয়েছি। এখন URL হবে: /hospital/history
        Route::get('/history', [BloodRequestController::class, 'history'])->name('hospital.history');

        Route::post('/update-stock', [HospitalController::class, 'updateStock'])->name('hospital.updateStock');
    });

    // --- MANAGER ROUTES ---
    /* =======================
    MANAGER ROUTES (Admin/Manager Panel)
======================= */
    Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {

        // ড্যাশবোর্ড এবং ইনভেন্টরি
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
        Route::get('/inventory', [ManagerController::class, 'inventory'])->name('manager.inventory');
        Route::post('/inventory', [InventoryController::class, 'store'])->name('manager.inventory.store');
        Route::get('/expiry-alerts', [InventoryController::class, 'expiryAlerts'])->name('manager.expiryAlerts');

        // ব্লাড রিকোয়েস্ট ম্যানেজমেন্ট (হাসপাতাল থেকে আসা)
        Route::get('/requests', [BloodRequestController::class, 'manage'])->name('manager.requests');
        Route::post('/requests/approve/{id}', [BloodRequestController::class, 'approve'])->name('manager.approve');
        Route::post('/requests/reject/{id}', [BloodRequestController::class, 'reject'])->name('manager.reject');

        // অ্যাপয়েন্টমেন্ট ম্যানেজমেন্ট (ডোনারদের থেকে আসা)
        Route::get('/appointments', [AppointmentController::class, 'manage'])->name('manager.appointments');
        Route::post('/appointments/approve/{id}', [AppointmentController::class, 'approve'])->name('manager.appointments.approve');

        // রিপোর্ট এবং অন্যান্য
        Route::get('/reports', [ManagerController::class, 'reports'])->name('manager.reports');
    });
});