@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-danger"><i class="fa-solid fa-droplet"></i> Blood Bank Management</h2>
        <span class="text-muted">Welcome back, Admin!</span>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-around bg-light rounded">
            <a href="/manager/inventory" class="btn btn-outline-danger btn-sm px-4"><i class="fa-solid fa-warehouse"></i> Inventory</a>
            <a href="/manager/requests" class="btn btn-outline-danger btn-sm px-4"><i class="fa-solid fa-hospital"></i> Hospital Requests</a>
            <a href="/manager/appointments" class="btn btn-outline-danger btn-sm px-4"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
            <a href="/manager/reports" class="btn btn-outline-danger btn-sm px-4"><i class="fa-solid fa-file-invoice"></i> Reports</a>
            <a href="/manager/expiry-alerts" class="btn btn-outline-danger btn-sm px-4"><i class="fa-solid fa-triangle-exclamation"></i> Expiry Alerts</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Total Blood Stock</h6>
                    <h2 class="mb-0 fw-bold">{{ $total_units ?? 0 }} Bags</h2>
                    <small>Available in all groups</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Pending Appointments</h6>
                    <h2 class="mb-0 fw-bold">{{ $pending_appts ?? 0 }}</h2>
                    <small>Donors waiting for approval</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Active Hospital Requests</h6>
                    <h2 class="mb-0 fw-bold">{{ $pending_requests ?? 0 }}</h2>
                    <small>Pending blood deliveries</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Current Stock Level</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Blood Group</th>
                        <th>Units Available</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                    <tr>
                        <td class="ps-4 fw-bold text-danger">{{ $item->blood_group }}</td>
                        <td>{{ $item->units }} Bags</td>
                        <td>
                            @if($item->units <= 2)
                                <span class="badge bg-soft-danger text-danger border border-danger">Critical</span>
                            @else
                                <span class="badge bg-success">Available</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No inventory data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-danger { background-color: #fce4e4; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
</style>
@endsection