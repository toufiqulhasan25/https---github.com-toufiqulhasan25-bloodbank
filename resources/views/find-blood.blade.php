@extends('layouts.frontend')

@section('title', 'Find Blood | NIYD Blood Bank')

@section('extra_css')
    <style>
        :root { --primary-red: #BE1E2D; --deep-navy: #002B49; --soft-bg: #f8f9fa; }
        .hero-search { background: linear-gradient(135deg, var(--deep-navy) 0%, #054a7d 100%); padding: 80px 0 120px; color: white; border-radius: 0 0 50px 50px; position: relative; }
        .search-box-container { margin-top: -80px; position: relative; z-index: 10; }
        .search-card { background: #fff; border-radius: 25px; padding: 35px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); border: none; }
        .custom-input { height: 52px; border-radius: 12px !important; border: 1px solid #eee !important; font-weight: 500; }
        .custom-input:focus { border-color: var(--primary-red) !important; box-shadow: 0 0 0 0.25rem rgba(190, 30, 45, 0.1) !important; }
        .search-btn { height: 52px; background: var(--primary-red) !important; border: none !important; color: white !important; font-weight: 700; letter-spacing: 1px; transition: 0.4s; }
        .result-item { background: #fff; border-radius: 20px; border: 1px solid #eee; transition: 0.3s ease; margin-bottom: 20px; position: relative; overflow: hidden; }
        .result-item:hover { transform: scale(1.01); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08); border-color: var(--primary-red); }
        .blood-icon { background: var(--primary-red); color: white; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 18px; font-weight: 800; font-size: 1.5rem; flex-shrink: 0; }
        .status-badge { font-size: 0.7rem; padding: 6px 14px; font-weight: 600; text-transform: uppercase; }
        .btn-action { border-radius: 50px; padding: 10px 25px; font-weight: 700; transition: 0.3s; }
        
        /* Modal Fixes */
        .modal-content { border-radius: 20px; border: none; overflow: hidden; }
        .modal-header { background: var(--primary-red); color: white; border: none; }
        .btn-close-white { filter: brightness(0) invert(1); }
    </style>
@endsection

@section('content')
    <section class="hero-search text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3" data-aos="fade-down">Find Life-Saving Blood</h1>
            <p class="lead opacity-75 mb-0" data-aos="fade-up">Connecting you with verified Donors and Hospitals.</p>
        </div>
    </section>

    <div class="container search-box-container mb-5">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="search-card" data-aos="zoom-in">
            <form action="{{ route('find.blood') }}" method="GET" id="searchForm" class="row g-4 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold small text-muted ms-2">Blood Group</label>
                    <select name="blood_group" class="form-select bg-light custom-input">
                        <option value="">All Groups</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                            <option value="{{ $group }}" {{ request('blood_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold small text-muted ms-2">Location</label>
                    <input type="text" name="location" class="form-control bg-light custom-input" placeholder="Enter City or Area" value="{{ request('location') }}">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold small text-muted ms-2">Search Scope</label>
                    <select name="type" class="form-select bg-light custom-input">
                        <option value="all">Any Source</option>
                        <option value="donor" {{ request('type') == 'donor' ? 'selected' : '' }}>Donors Only</option>
                        <option value="hospital" {{ request('type') == 'hospital' ? 'selected' : '' }}>Hospitals Only</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-danger w-100 search-btn shadow-sm">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> SEARCH
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-5 px-lg-4">
            <h4 class="fw-bold mb-0">Search Results ({{ $results->total() }})</h4>
            <p class="text-muted small mb-4">Verified results found in our database</p>

            @forelse($results as $item)
                <div class="result-item p-4 d-flex align-items-center justify-content-between flex-wrap gap-3 shadow-sm" data-aos="fade-up">
                    <div class="d-flex align-items-center">
                        <div class="blood-icon shadow-sm me-4">
                            @if($item->role == 'hospital')
                                <i class="fa-solid fa-hospital-user fs-4"></i>
                            @else
                                {{ $item->blood_group ?? '?' }}
                            @endif
                        </div>

                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge {{ $item->role == 'hospital' ? 'bg-warning-subtle text-dark border-warning' : 'bg-success-subtle text-success border-success' }} status-badge rounded-pill">
                                    {{ $item->role == 'hospital' ? 'Hospital Stock' : 'Verified Donor' }}
                                </span>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $item->name }}</h5>
                            <p class="text-muted small mb-0"><i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $item->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="text-lg-end text-start">
                        @if($item->role == 'hospital')
                            @php
                                $targetGroup = request('blood_group');
                                $stock = $item->stocks->where('blood_group', $targetGroup)->first();
                                $bagsCount = $stock ? $stock->bags : 0;
                            @endphp

                            <div class="mb-2">
                                @if($targetGroup && $bagsCount > 0)
                                    <span class="h4 fw-bold text-danger mb-0">{{ $bagsCount }}</span> <span class="text-muted small">Bags ({{ $targetGroup }})</span>
                                @elseif(!$targetGroup)
                                    <span class="badge bg-info text-white px-3 py-2 rounded-pill small">Select group to request</span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill small">Out of Stock</span>
                                @endif
                            </div>

                            @if($bagsCount > 0)
                                @auth
                                    <button type="button" class="btn btn-outline-dark btn-action shadow-sm" data-bs-toggle="modal" data-bs-target="#reqModal{{$item->id}}">
                                        <i class="fa-solid fa-paper-plane me-2"></i>Request Blood
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-danger btn-action shadow-sm">
                                        <i class="fa-solid fa-lock me-2"></i> Login to Request
                                    </a>
                                @endauth
                            @else
                                <button class="btn btn-light btn-action border" disabled><i class="fa-solid fa-ban me-2"></i> N/A</button>
                            @endif
                        @else
                            {{-- Donor Section --}}
                            @auth
                                <a href="tel:{{ $item->phone }}" class="btn btn-dark btn-action shadow-sm">
                                    <i class="fa-solid fa-phone me-2"></i>Call Now
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-action shadow-sm">
                                    <i class="fa-solid fa-lock me-2"></i> Login to Call
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fa-solid fa-magnifying-glass-blur display-1 text-muted mb-3"></i>
                    <h5>No results found for your criteria.</h5>
                </div>
            @endforelse

            <div class="mt-5 d-flex justify-content-center">
                {{ $results->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- Modals for Hospital Requests --}}
    @foreach($results as $item)
        @if($item->role == 'hospital')
            @php
                $targetGroup = request('blood_group');
                $stock = $item->stocks->where('blood_group', $targetGroup)->first();
                $bagsCount = $stock ? $stock->bags : 0;
            @endphp
            @if($bagsCount > 0)
                <div class="modal fade" id="reqModal{{$item->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('patient.request.store') }}" method="POST" class="modal-content shadow-lg">
                            @csrf
                            <input type="hidden" name="hospital_id" value="{{ $item->id }}">
                            <input type="hidden" name="blood_group" value="{{ $targetGroup }}">
                            
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Requesting {{ $targetGroup }} Blood</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control custom-input bg-light" required placeholder="Full Name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control custom-input bg-light" required placeholder="01XXXXXXXXX">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label fw-bold small">Bags Needed</label>
                                    <input type="number" name="bags" class="form-control custom-input bg-light" value="1" min="1" max="{{ $bagsCount }}" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-3">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger rounded-pill px-4">Confirm Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
@endsection