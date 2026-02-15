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
use App\Http\Controllers\Donor\DashboardController;
use App\Http\Controllers\ContactController;

/* =========================================================
    ১. পাবলিক রাউট
   ========================================================= */
Route::get('/', function () {
    return view('landing');
});
Route::get('/find-blood', [DonorSearchController::class, 'index'])->name('find.blood');
Route::get('/donate-info', function () {
    return view('donate-info');
});
Route::get('/hospitals-info', function () {
    return view('hospitals-info');
});

Route::get('/contact', function () {
    return view('contact'); // এখানে 'frontend.contact' এর বদলে শুধু 'contact' হবে
})->name('contact');
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');

/* =========================================================
    ২. গেস্ট রাউট
   ========================================================= */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/* =========================================================
    ৩. অথেন্টিকেটেড রাউট
   ========================================================= */
Route::middleware(['auth'])->group(function () {

    /* --- ডোনার রাউট (Donor) --- */
    Route::middleware('role:donor')->prefix('donor')->group(function () {
        Route::get('/dashboard', [DonorController::class, 'index'])->name('donor.dashboard');

        Route::post('/notifications/read/{id}', [DonorController::class, 'markNotificationRead'])->name('notifications.markRead');

        // প্রোফাইল রাউটসমূহ
        Route::get('/profile', [DonorController::class, 'profileShow'])->name('donor.profile.show');
        Route::post('/profile-update', [DonorController::class, 'profileUpdate'])->name('donor.profile.update');

        // অ্যাপয়েন্টমেন্ট এবং অন্যান্য
        Route::get('/appointments/{id}', [DonorController::class, 'showAppointment'])->name('donor.appointments.show');
        Route::get('/appointment', [AppointmentController::class, 'create'])->name('donor.appointment.create');
        Route::post('/appointment', [AppointmentController::class, 'store'])->name('donor.appointment.store');
        Route::get('/history', [DonorController::class, 'history'])->name('donor.history');
        Route::get('/card', [DonorController::class, 'generateCard'])->name('donor.card');
        Route::get('/certificate/{id}', [DonorController::class, 'downloadCertificate'])->name('donor.certificate');
        Route::get('/notify/{id}/{group}', [DonorController::class, 'sendCallNotification'])->name('donor.notify');
    });

    /* --- হাসপাতাল রাউট (Hospital) --- */
    /* --- হাসপাতাল রাউট (Hospital) --- */
    /* --- হাসপাতাল রাউট (Hospital) --- */
    Route::middleware('role:hospital')->prefix('hospital')->group(function () {

        // ১. ড্যাশবোর্ড এবং নোটিফিকেশন
        Route::get('/dashboard', [HospitalController::class, 'index'])->name('hospital.dashboard');

        // নোটিফিকেশন 'Read' মার্ক করার রাউট
        Route::post('/mark-notifications-read', [HospitalController::class, 'markRead'])->name('hospital.markRead');

        // ২. ব্লাড রিকোয়েস্ট এবং ডিটেইলস (History Section)
        Route::get('/request', [BloodRequestController::class, 'create'])->name('hospital.request.create');
        Route::post('/request', [BloodRequestController::class, 'store'])->name('hospital.request.store');
        Route::get('/history', [BloodRequestController::class, 'history'])->name('hospital.history');

        // হসপিটাল হিস্ট্রিতে 'Details' বাটনের জন্য এই রাউটটি কাজ করবে
        Route::get('/request-details/{id}', [BloodRequestController::class, 'show'])->name('hospital.request.show');

        // ৩. স্টক ম্যানেজমেন্ট
        Route::post('/update-stock', [HospitalController::class, 'updateStock'])->name('hospital.updateStock');

        Route::get('/patient-requests', [HospitalController::class, 'viewPatientRequests'])->name('hospital.patient.requests');
        // রিকোয়েস্ট এপ্রুভ করার জন্য (পরবর্তীতে লাগবে)
        Route::post('/patient-requests/approve/{id}', [HospitalController::class, 'approvePatientRequest'])->name('hospital.patient.approve');
        Route::post('/patient-requests/reject/{id}', [HospitalController::class, 'rejectPatientRequest'])->name('hospital.patient.reject');

        // ৪. প্রোফাইল ম্যানেজমেন্ট
        Route::get('/profile', [HospitalController::class, 'profileShow'])->name('hospital.profile.show');
        Route::post('/profile-update', [HospitalController::class, 'profileUpdate'])->name('hospital.profile.update');
    });

    // ইউজারদের রিকোয়েস্ট পাঠানোর জন্য
    Route::middleware(['auth'])->group(function () {
        Route::post('/patient-request/store', [BloodRequestController::class, 'storePatientRequest'])->name('patient.request.store');
    });

    // হাসপাতালের ড্যাশবোর্ডে রিকোয়েস্ট হ্যান্ডেল করার জন্য
    Route::middleware(['auth', 'role:hospital'])->prefix('hospital')->group(function () {
        Route::get('/patient-requests', [HospitalController::class, 'viewPatientRequests'])->name('hospital.patient.requests');
        Route::post('/patient-requests/approve/{id}', [HospitalController::class, 'approvePatientRequest'])->name('hospital.patient.approve');
    });

    /* --- ম্যানেজার রাউট (Manager) --- */
    /* --- ম্যানেজার রাউট (Manager) --- */
    Route::middleware('role:manager')->prefix('manager')->group(function () {

        Route::get('/admin/messages', [ContactController::class, 'index'])->name('admin.messages');
        // ১. ড্যাশবোর্ড ও প্রোফাইল
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
        Route::get('/profile', [ManagerController::class, 'profileShow'])->name('manager.profile.show');
        Route::post('/profile-update', [ManagerController::class, 'profileUpdate'])->name('manager.profile.update');
        // অন্য ইনভেন্টরি রাউটগুলোর সাথে এটি যোগ করুন
        Route::delete('/manager/inventory/{id}', [ManagerController::class, 'destroyInventory'])->name('manager.inventory.destroy');

        // ২. ইনভেন্টরি ম্যানেজমেন্ট
        Route::get('/inventory', [ManagerController::class, 'inventory'])->name('manager.inventory');
        // ইনভেন্টরি ডাটা সেভ করার জন্য (যদি আলাদা InventoryController থাকে)
        Route::post('/inventory/store', [InventoryController::class, 'store'])->name('manager.inventory.store');

        // ৩. ব্লাড রিকোয়েস্ট (Hospital Requests)
        Route::get('/requests', [BloodRequestController::class, 'manage'])->name('manager.requests');
        Route::post('/requests/approve/{id}', [ManagerController::class, 'approveRequest'])->name('manager.approve');
        Route::post('/requests/reject/{id}', [ManagerController::class, 'rejectRequest'])->name('manager.reject');

        // ৪. অ্যাপয়েন্টমেন্ট (Donor Appointments)
        Route::get('/appointments', [AppointmentController::class, 'manage'])->name('manager.appointments');
        Route::post('/appointments/approve/{id}', [ManagerController::class, 'approveAppointment'])->name('manager.appointments.approve');

        // ৫. রিপোর্টস ও অন্যান্য
        Route::get('/reports', [ManagerController::class, 'reports'])->name('manager.reports');
        Route::get('/expiry-alerts', [InventoryController::class, 'expiryAlerts'])->name('manager.expiryAlerts');
    });
});