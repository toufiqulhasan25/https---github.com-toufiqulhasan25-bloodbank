@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-danger text-center">
                        <i class="fa-solid fa-droplet me-2"></i>Post New Blood Request
                    </h4>
                    
                    <form action="{{ route('hospital.request.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Patient Name</label>
                                <input type="text" name="patient_name" class="form-control border-0 bg-light rounded-pill px-4" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Blood Group Needed</label>
                                <select name="blood_group" class="form-select border-0 bg-light rounded-pill px-4" required>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                        <option value="{{ $bg }}">{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Number of Bags</label>
                                <input type="number" name="bags_needed" class="form-control border-0 bg-light rounded-pill px-4" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Contact Number</label>
                                <input type="text" name="phone" class="form-control border-0 bg-light rounded-pill px-4" value="{{ Auth::user()->phone }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Location (Hospital Address)</label>
                                <input type="text" name="location" class="form-control border-0 bg-light rounded-pill px-4" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Reason (Optional)</label>
                                <textarea name="reason" class="form-control border-0 bg-light rounded-4 px-4" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold shadow-sm">Submit Request</button>
                            <a href="/hospital/dashboard" class="btn btn-link w-100 text-muted mt-2">Back to Dashboard</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection