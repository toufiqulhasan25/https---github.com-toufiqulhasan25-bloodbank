@extends('layouts.app')

@section('title', 'Donation History')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="fa-solid fa-clock-rotate-left text-danger me-2"></i>My Donation History</h3>
            <p class="text-muted">A record of your life-saving contributions.</p>
        </div>
        <a href="/donor/appointment" class="btn btn-outline-danger shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> New Donation
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-ghost border-0 p-4 bg-danger text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="fw-bold">You've saved up to 15 lives!</h4>
                        <p class="mb-0 opacity-75">Every donation can save up to 3 lives. Thank you for being a hero.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="display-4 fw-bold">05</div>
                        <div class="small text-uppercase">Total Donations</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-ghost border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">#</th>
                            <th>Date</th>
                            <th>Hospital / Center</th>
                            <th>Blood Group</th>
                            <th>Status</th>
                            <th class="text-center">Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4">1</td>
                            <td>
                                <div class="fw-bold">Oct 12, 2025</div>
                                <small class="text-muted">10:30 AM</small>
                            </td>
                            <td>Dhaka Medical College</td>
                            <td><span class="badge bg-danger">O+</span></td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Verified</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">2</td>
                            <td>
                                <div class="fw-bold">June 05, 2025</div>
                                <small class="text-muted">02:15 PM</small>
                            </td>
                            <td>United Hospital</td>
                            <td><span class="badge bg-danger">O+</span></td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Verified</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-download"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

<style>
    .card-ghost {
        border-radius: 15px;
        overflow: hidden;
    }
    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge {
        font-weight: 600;
    }
</style>
@endsection