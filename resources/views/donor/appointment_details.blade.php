@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Top Header Section --}}
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">Appointment Details</h5>
                    <a href="{{ route('donor.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">
                    {{-- Status Banner --}}
                    <div class="text-center mb-5">
                        <div class="mb-3">
                            @if($appointment->status == 'approved')
                                <i class="fa-solid fa-circle-check text-success display-4"></i>
                            @elseif($appointment->status == 'pending')
                                <i class="fa-solid fa-clock text-warning display-4"></i>
                            @else
                                <i class="fa-solid fa-circle-xmark text-danger display-4"></i>
                            @endif
                        </div>
                        <h3 class="fw-bold mb-1">Status: {{ ucfirst($appointment->status) }}</h3>
                        <p class="text-muted small">Appointment ID: #NIYD-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    {{-- Information Grid --}}
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Hospital / Blood Bank</label>
                            <p class="fw-bold fs-5 mb-0 text-danger">
                                <i class="fa-solid fa-hospital me-2"></i>{{ $appointment->hospital->name ?? 'N/A' }}
                            </p>
                            <small class="text-muted">{{ $appointment->hospital->address ?? '' }}</small>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Scheduled Date & Time</label>
                            <p class="fw-bold fs-5 mb-0">
                                <i class="fa-solid fa-calendar-day me-2"></i>{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}
                            </p>
                            <small class="text-muted"><i class="fa-solid fa-clock me-1"></i>{{ $appointment->time }}</small>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Donor Name</label>
                            <p class="fw-bold mb-0">{{ $appointment->donor_name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Blood Group Requested</label>
                            <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">{{ $appointment->blood_group }}</span>
                        </div>
                    </div>

                    {{-- Note Section --}}
                    @if($appointment->note)
                    <div class="p-3 bg-light rounded-3 mb-5">
                        <small class="fw-bold text-muted d-block mb-1">YOUR NOTES:</small>
                        <p class="mb-0 text-dark italic small">"{{ $appointment->note }}"</p>
                    </div>
                    @endif

                    <hr class="my-4" style="opacity: 0.1;">

                    {{-- Action Area --}}
                    <div class="text-center">
                        @if($appointment->status == 'approved')
                            <div class="alert alert-success border-0 rounded-4 mb-4">
                                <i class="fa-solid fa-gift me-2"></i>
                                <strong>Success!</strong> Your donation was recorded. You have earned points for your contribution.
                            </div>
                            <a href="{{ route('donor.certificate', $appointment->id) }}" class="btn btn-danger btn-lg px-5 rounded-pill shadow fw-bold">
                                <i class="fa-solid fa-file-arrow-down me-2"></i> Download Certificate (PDF)
                            </a>
                        @elseif($appointment->status == 'pending')
                            <div class="alert alert-warning border-0 rounded-4 mb-0">
                                <i class="fa-solid fa-hourglass-half me-2"></i>
                                <strong>Wait for Approval:</strong> The hospital is reviewing your slot. Check back soon.
                            </div>
                        @else
                            <div class="alert alert-danger border-0 rounded-4 mb-0">
                                <i class="fa-solid fa-circle-exclamation me-2"></i>
                                <strong>Rejected/Canceled:</strong> This request could not be fulfilled.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection