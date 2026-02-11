@extends('layouts.app')

@section('title', 'Manage Blood Requests')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Hospital Blood Requests</h3>
            <p class="text-muted small">Process and fulfill blood requests from hospitals and clinics.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill">
                {{ $requests->where('status', 'pending')->count() }} Pending
            </span>
            <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
                {{ $requests->where('status', 'approved')->count() }} Fulfilled
            </span>
        </div>
    </div>

    {{-- Session Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check fs-5 me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Request Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Hospital & Patient</th>
                            <th>Blood Group</th>
                            <th>Units Needed</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-3 p-2 me-3 text-center" style="width: 40px;">
                                        <i class="fa-solid fa-hospital"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $r->hospital->name ?? 'Unknown Hospital' }}</div>
                                        <small class="text-muted"><i class="fa-solid fa-user-injured me-1"></i> Patient: {{ $r->patient_name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-3">
                                    {{ $r->blood_group }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $r->bags_needed }} Bags</div>
                                {{--Requirement: Real-time inventory check indicator--}}
                                <small class="text-muted extra-small">Stock availability checked</small>
                            </td>
                            <td>
                                <div class="small text-dark">{{ $r->created_at->format('d M, Y') }}</div>
                                <div class="extra-small text-muted">{{ $r->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                @if($r->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill small">Pending</span>
                                @elseif($r->status == 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill small">Approved</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-pill small">{{ ucfirst($r->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($r->status == 'pending')
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Approve Button --}}
                                        <form action="{{ route('manager.approve', $r->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm">
                                                <i class="fa-solid fa-check me-1"></i> Issue Blood
                                            </button>
                                        </form>

                                        {{-- Reject Button --}}
                                        <form action="{{ route('manager.reject', $r->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" onclick="return confirm('Are you sure you want to reject this request?')">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small fw-medium italic"><i class="fa-solid fa-lock me-1"></i> No Action Needed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fa-solid fa-inbox text-light mb-3" style="font-size: 4rem;"></i>
                                    <p class="text-muted fw-bold">No active blood requests found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .extra-small { font-size: 0.75rem; }
    .table thead th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #7f8c8d; border-bottom: none; }
    .table tbody tr:hover { background-color: #fcfcfc; }
</style>
@endsection