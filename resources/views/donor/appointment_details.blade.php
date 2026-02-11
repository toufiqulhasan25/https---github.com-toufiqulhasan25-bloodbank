@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Appointment Details</h5>
                        <a href="{{ route('donor.dashboard') }}"
                            class="btn btn-sm btn-outline-secondary rounded-pill">Back</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small uppercase d-block">Hospital</label>
                                <p class="fw-bold fs-5">{{ $appointment->hospital->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small uppercase d-block">Status</label>
                                <span
                                    class="badge rounded-pill px-3 py-2 
                                    {{ $appointment->status == 'approved' ? 'bg-success' : ($appointment->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small uppercase d-block">Donation Date</label>
                                <p class="fw-bold">{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small uppercase d-block">Appointment ID</label>
                                <p class="fw-bold text-muted">#NIYD-{{ $appointment->id }}</p>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="text-center">
                            @if($appointment->status == 'approved')
                                <div class="alert alert-success border-0 rounded-4 mb-4">
                                    <i class="fa-solid fa-circle-check me-2"></i>
                                    Congratulations! Your donation was successful. You can now download your certificate.
                                </div>
                                <a href="{{ route('donor.certificate', $appointment->id) }}"
                                    class="btn btn-danger px-5 py-3 rounded-pill shadow">
                                    <i class="fa-solid fa-file-arrow-down me-2"></i> Download Certificate (PDF)
                                </a>
                            @elseif($appointment->status == 'pending')
                                <div class="alert alert-warning border-0 rounded-4">
                                    <i class="fa-solid fa-clock me-2"></i>
                                    This appointment is currently pending approval from the hospital.
                                </div>
                            @else
                                <div class="alert alert-danger border-0 rounded-4">
                                    <i class="fa-solid fa-circle-xmark me-2"></i>
                                    This appointment was rejected or canceled.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection