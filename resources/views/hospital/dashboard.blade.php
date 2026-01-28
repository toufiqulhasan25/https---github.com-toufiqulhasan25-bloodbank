@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-hospital-user text-danger" style="font-size: 50px;"></i>
                    </div>
                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <span class="badge bg-danger px-3 py-2 rounded-pill">Hospital Account</span>
                    <hr>
                    <div class="text-start mb-3">
                        <small class="text-muted d-block">Phone Number:</small>
                        <span class="fw-bold">{{ $user->phone }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h3 class="fw-bold mb-4">Hospital Overview</h3>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-primary text-white rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Blood Requests</h6>
                                    <h2 class="fw-bold">0</h2> </div>
                                <i class="fa-solid fa-hand-holding-droplet fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-success text-white rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">Blood Inventory</h6>
                                    <h2 class="fw-bold">0 Bags</h2>
                                </div>
                                <i class="fa-solid fa-droplet fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Recent Blood Requests</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient/Requester</th>
                                    <th>Blood Group</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No recent requests found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection