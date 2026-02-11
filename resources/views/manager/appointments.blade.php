@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Donor Appointments</h3>
            <p class="text-muted">Review and approve scheduled blood donations.</p>
        </div>
        <div class="bg-white p-2 px-4 rounded-pill shadow-sm border border-light">
            <span class="small fw-bold text-muted">Total Requests: {{ $apps->count() }}</span>
        </div>
    </div>

    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Donor Details</th>
                        <th>Hospital / Location</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apps as $a)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center py-2">
                                    <div class="avatar-sm bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold">{{ substr($a->donor_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $a->donor_name }}</h6>
                                        <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">Group: {{ $a->blood_group }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium">
                                    <i class="fa-solid fa-hospital text-danger me-1"></i> 
                                    {{ $a->hospital->name ?? 'Main Center' }}
                                </div>
                                <div class="text-muted extra-small" style="font-size: 0.75rem;">
                                    {{ $a->hospital->address ?? 'Address not found' }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold mb-0 small text-dark">
                                    <i class="fa-regular fa-calendar-check text-muted me-1"></i> 
                                    {{ \Carbon\Carbon::parse($a->date)->format('d M, Y') }}
                                </div>
                                <div class="small text-muted">
                                    <i class="fa-regular fa-clock me-1"></i> {{ \Carbon\Carbon::parse($a->time)->format('h:i A') }}
                                </div>
                            </td>
                            <td>
                                @if($a->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill small">
                                        <i class="fa-solid fa-spinner fa-spin me-1"></i> Pending
                                    </span>
                                @elseif($a->status == 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill small">
                                        <i class="fa-solid fa-check-double me-1"></i> Approved
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-pill small">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($a->status == 'pending')
                                    <form method="POST" action="{{ route('manager.appointments.approve', $a->id) }}" class="d-inline shadow-sm">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 fw-bold border-0">
                                            Approve
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small italic fw-medium"><i class="fa-solid fa-lock me-1"></i> Processed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fa-solid fa-calendar-xmark text-light mb-3" style="font-size: 4rem;"></i>
                                    <p class="text-muted fw-bold">No donation requests found at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }
    
    .table thead th { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        font-weight: 700;
        color: #7f8c8d;
        border-bottom: 2px solid #f8f9fa;
    }
    .table tbody tr:hover {
        background-color: #fcfcfc;
    }
    .badge { font-weight: 600; }
</style>
@endsection