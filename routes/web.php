<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReportController;

Route::get('/', fn() => view('landing'));

/* =======================
   AUTH ROUTES
======================= */
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

/* =======================
   DONOR ROUTES
======================= */
Route::middleware(['auth', 'role:donor'])->group(function () {

    Route::get('/donor/dashboard', fn() => view('donor.dashboard'));

    Route::get('/donor/appointment', [AppointmentController::class, 'create']);
    Route::post('/donor/appointment', [AppointmentController::class, 'store']);

});

/* =======================
   HOSPITAL ROUTES
======================= */
Route::middleware(['auth', 'role:hospital'])->group(function () {

    Route::get('/hospital/dashboard', fn() => view('hospital.dashboard'));

    Route::get('/hospital/request', [BloodRequestController::class, 'create']);
    Route::post('/hospital/request', [BloodRequestController::class, 'store']);

});

/* =======================
   MANAGER ROUTES
======================= */
Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', fn() => view('manager.dashboard'));

    // Inventory
    Route::get('/manager/inventory', [InventoryController::class, 'index']);
    Route::post('/manager/inventory', [InventoryController::class, 'store']);

    // Requests
    Route::get('/manager/requests', [BloodRequestController::class, 'manage']);
    Route::post('/manager/requests/{id}', [BloodRequestController::class, 'approve']);

    // Appointments
    Route::get('/manager/appointments', [AppointmentController::class, 'manage']);
    Route::post('/manager/appointments/{id}', [AppointmentController::class, 'approve']);

    // Reports
    Route::get('/manager/reports', [ReportController::class, 'index']);

});

Route::get('/manager/expiry-alerts', [InventoryController::class, 'expiryAlerts']);

Route::middleware('auth')->group(function () {

    Route::get('/donor/dashboard', fn() => view('donor.dashboard'));
    Route::get('/hospital/dashboard', fn() => view('hospital.dashboard'));
    Route::get('/manager/dashboard', fn() => view('manager.dashboard'));

    Route::get('/manager/inventory', [InventoryController::class, 'index']);
    Route::post('/manager/inventory', [InventoryController::class, 'store']);

    Route::get('/hospital/request', [BloodRequestController::class, 'create']);
    Route::post('/hospital/request', [BloodRequestController::class, 'store']);

    Route::get('/manager/requests', [BloodRequestController::class, 'manage']);
    Route::post('/manager/requests/{id}', [BloodRequestController::class, 'approve']);

    Route::get('/donor/appointment', [AppointmentController::class, 'create']);
    Route::post('/donor/appointment', [AppointmentController::class, 'store']);

    Route::get('/manager/appointments', [AppointmentController::class, 'manage']);
    Route::post('/manager/appointments/{id}', [AppointmentController::class, 'approve']);

    Route::get('/manager/reports', [ReportController::class, 'index']);
    Route::get('/manager/expiry-alerts', [InventoryController::class, 'expiryAlerts']);
});
