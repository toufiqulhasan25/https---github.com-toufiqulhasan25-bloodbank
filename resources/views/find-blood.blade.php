@extends('layouts.frontend')

@section('title', 'Find Blood | NIYD Blood Bank')

@section('styles')
<style>
    :root { --primary-red: #BE1E2D; --deep-navy: #002B49; }
    .hero-search {
        background: var(--deep-navy);
        padding: 60px 0 100px;
        color: white;
        border-radius: 0 0 50px 50px;
    }
    .search-box-container { margin-top: -70px; }
    .search-card {
        background: #fff;
        border-radius: 25px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border: none;
    }
    /* ইনপুট এবং বাটনগুলোর উচ্চতা সমান করার জন্য */
    .custom-input {
        height: 48px;
        border-radius: 10px !important;
    }
    .search-btn {
        height: 48px;
        background: var(--primary-red) !important;
        border: none !important;
        color: white !important;
        transition: 0.3s;
    }
    .search-btn:hover { background: #a11825 !important; transform: scale(1.02); }
    
    .result-item {
        background: #fff; border-radius: 20px; border: 1px solid #eee;
        transition: 0.3s; margin-bottom: 15px;
    }
    .result-item:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .blood-icon {
        background: var(--primary-red); color: white; width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 15px; font-weight: 800; font-size: 1.4rem;
    }
</style>
@endsection

@section('content')
<section class="hero-search text-center">
    <div class="container">
        <h1 class="fw-bold">Find Blood Fast</h1>
        <p class="opacity-75">Search availability in Hospitals or find Individual Donors nearby</p>
    </div>
</section>

<div class="container search-box-container mb-5">
    <div class="search-card">
        <form action="{{ route('find.blood') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Required Blood Group</label>
                <select name="blood_group" class="form-select bg-light border-0 custom-input">
                    <option value="">All Groups</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                        <option value="{{ $group }}" {{ request('blood_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold small text-muted">Preferred Location</label>
                <input type="text" name="location" class="form-control bg-light border-0 custom-input" placeholder="e.g. Dhaka, Chittagong" value="{{ request('location') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Source Type</label>
                <select name="type" class="form-select bg-light border-0 custom-input">
                    <option value="all">Any Source</option>
                    <option value="donor" {{ request('type') == 'donor' ? 'selected' : '' }}>Direct Donor</option>
                    <option value="hospital" {{ request('type') == 'hospital' ? 'selected' : '' }}>Hospital / Inventory</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill search-btn shadow-sm">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> SEARCH
                </button>
            </div>
        </form>
    </div>

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Availability Results</h5>
            <span class="badge bg-light text-dark border">{{ count($results) }} Found</span>
        </div>
        
        @forelse($results as $item)
        <div class="result-item p-3 d-flex align-items-center justify-content-between flex-wrap gap-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="blood-icon shadow-sm me-3">{{ $item->blood_group }}</div>
                <div>
                    <span class="badge rounded-pill bg-light text-dark border small mb-1">{{ strtoupper($item->role) }}</span>
                    <h6 class="fw-bold mb-0 mt-1">{{ $item->name }}</h6>
                    <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $item->address }}</small>
                </div>
            </div>
            <div class="text-end">
                @if($item->role == 'hospital')
                    <div class="mb-2"><span class="text-danger fw-bold">{{ $item->stock_count ?? '0' }} Bags</span> in stock</div>
                    <a href="#" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold">Request Now</a>
                @else
                    <div class="mb-2"><span class="text-success fw-bold small"><i class="fa-solid fa-circle-check"></i> Ready to Donate</span></div>
                    <a href="tel:{{ $item->phone }}" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-phone me-1"></i> Call Donor
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-5 card border-0 shadow-sm rounded-4">
            <i class="fa-solid fa-droplet-slash fs-1 text-muted mb-3 opacity-25"></i>
            <h5 class="text-muted">No blood sources found for this group.</h5>
            <p class="small text-secondary">Try searching in a different location or blood group.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection