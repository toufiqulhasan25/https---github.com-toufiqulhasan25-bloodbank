@extends('layouts.app')

@section('title', 'Request History')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-clock-rotate-left text-danger me-2"></i>Blood Request History
            </h3>
            <p class="text-muted small">Monitor the status of your outgoing blood requests to the manager</p>
        </div>
        <a href="{{ route('hospital.request.create') }}" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
            <i class="fa-solid fa-plus me-2"></i>New Request
        </a>
    </div>

    {{-- Stats Row (Optional but looks professional) --}}
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                <h6 class="text-muted small text-uppercase fw-bold">Total Requests</h6>
                <h3 class="fw-bold mb-0 text-primary">{{ $requests->total() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                <h6 class="text-muted small text-uppercase fw-bold">Pending</h6>
                <h3 class="fw-bold mb-0 text-warning">{{ $requests->where('status', 'pending')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                <h6 class="text-muted small text-uppercase fw-bold">Approved</h6>
                <h3 class="fw-bold mb-0 text-success">{{ $requests->where('status', 'approved')->count() }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Date</th>
                            <th>Patient Details</th>
                            <th>Blood Group</th>
                            <th>Requested Bags</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-4">
                                <span class="d-block fw-bold text-dark">{{ $req->created_at->format('d M, Y') }}</span>
                                <small class="text-muted">{{ $req->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle p-2 me-2 text-center" style="width: 35px; height: 35px; line-height: 18px;">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $req->patient_name }}</h6>
                                        <small class="text-muted">{{ $req->contact_number ?? 'No Contact' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                                    <i class="fa-solid fa-droplet me-1"></i> {{ $req->blood_group }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $req->bags ?? $req->bags_needed }}</span> 
                                <span class="text-muted small">Units</span>
                            </td>
                            <td>
                                @if($req->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning px-3 rounded-pill border border-warning">
                                        <i class="fa-solid fa-spinner fa-spin me-1"></i> Pending
                                    </span>
                                @elseif($req->status == 'approved')
                                    <span class="badge bg-success-subtle text-success px-3 rounded-pill border border-success">
                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 rounded-pill border border-danger">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('hospital.request.show', $req->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm border-2">
                                    View <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3" alt="">
                                <p class="mb-0">You haven't made any blood requests yet.</p>
                                <a href="{{ route('hospital.request.create') }}" class="btn btn-sm btn-danger mt-3 rounded-pill">Make First Request</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $requests->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    .bg-warning-subtle { background-color: #fff3cd !important; color: #856404 !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; color: #0f5132 !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; color: #842029 !important; }
    .table-hover tbody tr:hover { background-color: #fdfdfd; transition: 0.3s; }
</style>
@endsection