@extends('layouts.app')

@section('page_title', 'Request Details')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Back Button --}}
            <div class="mb-3">
                <a href="{{ route('hospital.history') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to History
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-3 text-center">
                    <h5 class="fw-bold mb-0">Blood Request Information</h5>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        {{-- Blood Group Icon --}}
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <h2 class="fw-bold mb-0">{{ $bloodRequest->blood_group }}</h2>
                        </div>
                        
                        {{-- Status Badge --}}
                        <div>
                            @if($bloodRequest->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-clock me-1"></i> Pending Approval
                                </span>
                            @elseif($bloodRequest->status == 'approved')
                                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-circle-check me-1"></i> Approved
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Details Table --}}
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted fw-semibold" style="width: 40%;">Request ID</th>
                                    <td class="py-3 fw-bold text-end">#BR-{{ str_pad($bloodRequest->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted fw-semibold">Blood Group</th>
                                    <td class="py-3 fw-bold text-end text-danger">{{ $bloodRequest->blood_group }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted fw-semibold">Requested Units (Bags)</th>
                                    <td class="py-3 fw-bold text-end">{{ $bloodRequest->units }} Bag(s)</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted fw-semibold">Patient Name</th>
                                    <td class="py-3 fw-bold text-end">{{ $bloodRequest->patient_name ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted fw-semibold">Request Date</th>
                                    <td class="py-3 fw-bold text-end text-muted">{{ $bloodRequest->created_at->format('d M, Y | h:i A') }}</td>
                                </tr>
                                @if($bloodRequest->reason)
                                <tr>
                                    <th class="py-3 text-muted fw-semibold">Reason/Note</th>
                                    <td class="py-3 text-end">{{ $bloodRequest->reason }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Action Button for Approved Requests --}}
                    @if($bloodRequest->status == 'approved')
                        <div class="alert alert-info border-0 rounded-4 mt-4 text-center">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Your request has been approved. Please contact the management for blood collection.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection