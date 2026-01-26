@extends('layouts.frontend') {{-- আপনার মাস্টার ফাইল অনুযায়ী নাম দিন --}}

@section('title', 'Hospitals Info | NIYD')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Registered Hospitals & Units</h2>
        <p class="text-muted">Find our partner hospitals and blood bank units near you.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-3 me-3">
                        <i class="fa-solid fa-hospital-user fs-3 text-danger"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Central University Medical Center</h5>
                        <p class="small text-muted mb-0"><i class="fa-solid fa-location-dot"></i> Main Campus, Sector 07</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-success">Open 24/7</span>
                    <a href="tel:0123456789" class="btn btn-sm btn-outline-danger rounded-pill">Contact Unit</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-3 me-3">
                        <i class="fa-solid fa-hospital fs-3 text-danger"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">City General Blood Bank</h5>
                        <p class="small text-muted mb-0"><i class="fa-solid fa-location-dot"></i> Downtown, Road 12</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-success">Open 24/7</span>
                    <a href="tel:0123456789" class="btn btn-sm btn-outline-danger rounded-pill">Contact Unit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection