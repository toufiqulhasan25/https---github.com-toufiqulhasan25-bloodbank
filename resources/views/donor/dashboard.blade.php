@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Donor Dashboard</h3>
            <p class="text-muted">Welcome back! Your contribution saves lives.</p>
        </div>
        <a href="/donor/appointment" class="btn btn-danger px-4 shadow-sm">
            <i class="fa-solid fa-calendar-plus me-2"></i>Book Appointment
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-ghost border-0 p-4" style="border-left: 5px solid #dc3545 !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-light-danger text-danger p-3 rounded-circle me-3">
                        <i class="fa-solid fa-droplet fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Donations</h6>
                        <h3 class="fw-bold mb-0">05 Times</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-ghost border-0 p-4" style="border-left: 5px solid #198754 !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-light-success text-success p-3 rounded-circle me-3">
                        <i class="fa-solid fa-heart-pulse fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Last Donated</h6>
                        <h3 class="fw-bold mb-0">12 Oct 2025</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-ghost border-0 p-4" style="border-left: 5px solid #0dcaf0 !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-light-info text-info p-3 rounded-circle me-3">
                        <i class="fa-solid fa-clock fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Next Eligibility</h6>
                        <h3 class="fw-bold mb-0">In 15 Days</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-ghost border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Recent Appointments</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Hospital</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">Jan 20, 2026</td>
                                    <td>City Central Hospital</td>
                                    <td><span class="badge bg-success-subtle text-success px-3">Completed</span></td>
                                    <td class="text-end pe-4"><a href="#" class="btn btn-sm btn-light">Details</a></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Feb 05, 2026</td>
                                    <td>Red Crescent Care</td>
                                    <td><span class="badge bg-warning-subtle text-warning px-3">Pending</span></td>
                                    <td class="text-end pe-4"><a href="#" class="btn btn-sm btn-light">Details</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 bg-primary text-white p-4 mb-4">
                <h5 class="fw-bold">Health Tip</h5>
                <p class="small mb-0">Drink plenty of water and have a healthy meal before your donation. Your health is our priority!</p>
            </div>
            
            <div class="card card-ghost border-0 p-4 text-center">
                <i class="fa-solid fa-certificate text-warning fa-3x mb-3"></i>
                <h5 class="fw-bold">Donor Level: Gold</h5>
                <p class="text-muted small">You are in the top 10% of donors in your area!</p>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-warning" style="width: 75%"></div>
                </div>
                <small class="mt-2 d-block text-muted">2 more donations for Platinum</small>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-danger { background-color: #f8d7da; }
    .bg-light-success { background-color: #d1e7dd; }
    .bg-light-info { background-color: #cff4fc; }
    
    .badge {
        font-weight: 500;
        border-radius: 30px;
    }
</style>
@endsection