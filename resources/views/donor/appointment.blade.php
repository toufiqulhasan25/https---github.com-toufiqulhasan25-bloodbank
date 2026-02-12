@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fw-bold mb-1"><i class="fa-solid fa-calendar-check text-danger me-2"></i>Book Appointment</h3>
                    <p class="text-muted mb-0">Schedule your donation at your preferred hospital.</p>
                </div>
                <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Cancel</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Decorative Header --}}
                <div style="height: 6px; background: linear-gradient(90deg, #dc3545, #961824);"></div>
                
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ url('/donor/appointment') }}">
                        @csrf
                        <div class="row g-4">
                            {{-- Hospital Selection --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted uppercase">Select Hospital / Blood Bank</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-hospital text-danger"></i></span>
                                    <select name="hospital_id" class="form-select border-start-0 bg-light" required>
                                        <option value="" selected disabled>Choose where you want to donate</option>
                                        @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}">{{ $hospital->name }} ({{ $hospital->address }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Donor Name & Blood Group --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted uppercase">Your Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user"></i></span>
                                    <input name="donor_name" class="form-control border-start-0 bg-light" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted uppercase">Blood Group</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-droplet text-danger"></i></span>
                                    <select name="blood_group" class="form-select border-start-0 bg-light" required>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}" {{ auth()->user()->blood_group == $group ? 'selected' : '' }}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Date & Time --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted uppercase">Preferred Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-calendar-day text-muted"></i></span>
                                    <input type="date" name="date" class="form-control border-start-0 bg-light" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted uppercase">Preferred Time</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-clock text-muted"></i></span>
                                    <input type="time" name="time" class="form-control border-start-0 bg-light" required>
                                </div>
                            </div>

                            {{-- Note --}}
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted uppercase">Special Notes (Optional)</label>
                                <textarea name="note" class="form-control bg-light" rows="3" placeholder="Any medical conditions or questions?"></textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-bold shadow-sm py-3">
                                <i class="fa-solid fa-paper-plane me-2"></i> Confirm Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-4 p-3 bg-white rounded shadow-sm border-start border-danger border-4">
                <p class="mb-0 small text-muted">
                    <i class="fa-solid fa-info-circle text-danger me-1"></i> 
                    <strong>Reminder:</strong> Please ensure you haven't donated blood in the last 90 days.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection