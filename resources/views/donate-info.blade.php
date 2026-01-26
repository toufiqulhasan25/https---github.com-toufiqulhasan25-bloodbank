@extends('layouts.frontend')

@section('content')
<div class="container text-center py-5">
    <h1 class="fw-bold" style="color: #002B49;">Be a Hero – Save a Life</h1>
    <p class="text-muted">Your one donation can save up to three lives.</p>

    <div class="mt-4">
        <a href="{{ url('/register') }}" class="btn btn-danger btn-lg rounded-pill px-5 shadow-sm" 
           style="background-color: #BE1E2D; border: none; font-weight: 600;">
            Become a Donor
        </a>
    </div>

    <div class="row mt-5 g-4 text-start">
        <div class="col-md-4">
            <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
                <h5 class="fw-bold"><i class="fas fa-user-plus text-danger me-2"></i> 1. Registration</h5>
                <p class="small text-muted">Sign up on our platform as a donor. It only takes a minute to join the community.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
                <h5 class="fw-bold"><i class="fas fa-notes-medical text-danger me-2"></i> 2. Health Check</h5>
                <p class="small text-muted">A quick check-up by the hospital manager to ensure you're fit for donation.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-4 shadow-sm h-100 bg-white">
                <h5 class="fw-bold"><i class="fas fa-hand-holding-medical text-danger me-2"></i> 3. Donation</h5>
                <p class="small text-muted">The process takes about 10-15 mins. Afterward, you get a certificate and a feeling of joy!</p>
            </div>
        </div>
    </div>

    <div class="mt-5 p-5 border rounded-4 bg-light">
        <h3 class="fw-bold mb-4">Who can give blood?</h3>
        <div class="row">
            <div class="col-md-3">
                <h4 class="text-danger fw-bold">18-60</h4>
                <p class="small">Age Range</p>
            </div>
            <div class="col-md-3">
                <h4 class="text-danger fw-bold">50kg+</h4>
                <p class="small">Min Weight</p>
            </div>
            <div class="col-md-3">
                <h4 class="text-danger fw-bold">Good</h4>
                <p class="small">Overall Health</p>
            </div>
            <div class="col-md-3">
                <h4 class="text-danger fw-bold">3 Months</h4>
                <p class="small">Donation Gap</p>
            </div>
        </div>
    </div>
</div>
@endsection