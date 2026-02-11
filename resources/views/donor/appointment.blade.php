@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <h3 class="fw-bold"><i class="fa-solid fa-calendar-check text-danger me-2"></i>Book an Appointment</h3>
                <p class="text-muted">Schedule your donation time and help us save lives.</p>
            </div>

            <div class="card card-ghost border-0 shadow-sm overflow-hidden">
                <div style="height: 5px; background: linear-gradient(90deg, #dc3545, #ff4d5a);"></div>
                
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="/donor/appointment">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-semibold">Select Hospital / Blood Bank</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-hospital text-danger"></i></span>
                                    <select name="hospital_id" class="form-select border-start-0 bg-light" required>
                                        <option value="" selected disabled>Choose where you want to donate</option>
                                        @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}">{{ $hospital->name }} - {{ $hospital->address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Your Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                                    <input name="donor_name" class="form-control border-start-0 bg-light" 
                                           placeholder="Enter your name" value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Blood Group</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-droplet text-danger"></i></span>
                                    <select name="blood_group" class="form-select border-start-0 bg-light" required>
                                        <option value="" disabled>Select Group</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}" {{ (auth()->user()->blood_group == $group) ? 'selected' : '' }}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Preferred Date</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-calendar-day text-muted"></i></span>
                                    <input type="date" name="date" class="form-control border-start-0 bg-light" 
                                           min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Preferred Time</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-clock text-muted"></i></span>
                                    <input type="time" name="time" class="form-control border-start-0 bg-light" required>
                                </div>
                            </div>
                        </div>

                        {{-- আপনার কন্ট্রোলারে 'notes' এর বদলে 'note' (সিঙ্গুলার) থাকলে নাম মিলিয়ে নিন --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Notes (Optional)</label>
                            <textarea name="note" class="form-control bg-light" rows="2" placeholder="Any health info or specific requirements?"></textarea>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-danger btn-lg fw-bold shadow-sm">
                                <i class="fa-solid fa-paper-plane me-2"></i>Confirm Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-white rounded shadow-sm border-start border-primary border-4">
                <p class="mb-0 small text-muted">
                    <i class="fa-solid fa-circle-info text-primary me-1"></i> 
                    <strong>Note:</strong> Please arrive 15 minutes before your scheduled time. Bring a valid Photo ID.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: none;
        background-color: #fff !important;
    }
    .input-group-text { border: 1px solid #ced4da; }
    .form-label { font-size: 0.9rem; color: #495057; }
</style>
@endsection