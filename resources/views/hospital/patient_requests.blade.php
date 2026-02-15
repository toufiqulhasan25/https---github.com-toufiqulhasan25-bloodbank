@extends('layouts.app') {{-- বা আপনার হাসপাতালের জন্য নির্ধারিত লেআউট --}}

@section('title', 'Patient Blood Requests')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-hand-holding-medical text-danger me-2"></i>Patient Blood Requests
                </h3>
                <p class="text-muted small">Manage and respond to blood requests from registered users/donors</p>
            </div>
            {{-- এখানে স্ট্যাটাস অনুযায়ী ফিল্টারিং বা অন্য কোনো বাটন চাইলে যোগ করা যায় --}}
        </div>

        {{-- Stats Row --}}
        <div class="row g-3 mb-4 text-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                    <h6 class="text-muted small text-uppercase fw-bold">Incoming Requests</h6>
                    <h3 class="fw-bold mb-0 text-primary">{{ $requests->total() }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                    <h6 class="text-muted small text-uppercase fw-bold">Needs Action</h6>
                    <h3 class="fw-bold mb-0 text-warning">{{ $requests->where('status', 'pending')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                    <h6 class="text-muted small text-uppercase fw-bold">Fulfilled</h6>
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
                                <th class="ps-4 py-3">Patient & Requester</th>
                                <th>Blood Group</th>
                                <th>Units Needed</th>
                                <th>Contact Info</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-danger-subtle rounded-circle p-2 me-3 text-center"
                                                style="width: 40px; height: 40px; line-height: 22px;">
                                                <i class="fa-solid fa-user-injured text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">{{ $req->patient_name }}</h6>
                                                <small class="text-muted">Requested by:
                                                    {{ $req->user->name ?? 'Guest Donor' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                                            <i class="fa-solid fa-droplet me-1"></i> {{ $req->blood_group }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $req->bags }}</span>
                                        <span class="text-muted small">Units</span>
                                    </td>
                                    <td>
                                        <span class="text-dark"><i class="fa-solid fa-phone me-1 text-muted small"></i>
                                            {{ $req->contact_number }}</span>
                                    </td>
                                    <td>
                                        @if($req->status == 'pending')
                                            <span
                                                class="badge bg-warning-subtle text-warning px-3 rounded-pill border border-warning">
                                                <i class="fa-solid fa-spinner fa-spin me-1"></i> Pending
                                            </span>
                                        @elseif($req->status == 'approved')
                                            <span
                                                class="badge bg-success-subtle text-success px-3 rounded-pill border border-success">
                                                <i class="fa-solid fa-check-double me-1"></i> Approved
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 rounded-pill border border-danger">
                                                <i class="fa-solid fa-xmark me-1"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($req->status == 'pending')
                                            {{-- Approve Button --}}
                                            <form action="{{ route('hospital.patient.approve', $req->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-bold">
                                                    Approve <i class="fa-solid fa-check ms-1"></i>
                                                </button>
                                            </form>

                                            {{-- Reject Button --}}
                                            <form action="{{ route('hospital.patient.reject', $req->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm fw-bold"
                                                    onclick="return confirm('Are you sure you want to reject this request?')">
                                                    Reject <i class="fa-solid fa-xmark ms-1"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small italic">Processed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/10044/10044874.png" width="80"
                                            class="opacity-25 mb-3" alt="">
                                        <p class="mb-0 fw-bold">No patient blood requests available at the moment.</p>
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
        .bg-warning-subtle {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
            color: #0f5132 !important;
        }

        .bg-danger-subtle {
            background-color: #f8d7da !important;
            color: #842029 !important;
        }

        .table-hover tbody tr:hover {
            background-color: #fdfdfd;
            transition: 0.3s;
        }

        .avatar-sm {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection