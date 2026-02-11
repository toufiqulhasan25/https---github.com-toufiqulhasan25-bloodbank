@extends('layouts.frontend')

@section('title', 'Find Blood | NIYD Blood Bank')

@section('extra_css')
<style>
    :root { 
        --primary-red: #BE1E2D; 
        --deep-navy: #002B49; 
        --soft-bg: #f8f9fa;
    }
    
    /* Hero Search Section */
    .hero-search {
        background: linear-gradient(135deg, var(--deep-navy) 0%, #054a7d 100%);
        padding: 80px 0 120px;
        color: white;
        border-radius: 0 0 50px 50px;
        position: relative;
    }

    .search-box-container { margin-top: -80px; position: relative; z-index: 10; }
    
    .search-card {
        background: #fff;
        border-radius: 25px;
        padding: 35px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        border: none;
    }

    .custom-input {
        height: 52px;
        border-radius: 12px !important;
        border: 1px solid #eee !important;
        font-weight: 500;
    }
    .custom-input:focus {
        border-color: var(--primary-red) !important;
        box-shadow: 0 0 0 0.25rem rgba(190, 30, 45, 0.1) !important;
    }

    .search-btn {
        height: 52px;
        background: var(--primary-red) !important;
        border: none !important;
        color: white !important;
        font-weight: 700;
        letter-spacing: 1px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .search-btn:hover { 
        background: #a11825 !important; 
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(190, 30, 45, 0.3) !important;
    }
    
    /* Result Items */
    .result-item {
        background: #fff; 
        border-radius: 20px; 
        border: 1px solid #eee;
        transition: 0.3s ease; 
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .result-item:hover { 
        transform: scale(1.01); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.08); 
        border-color: var(--primary-red);
    }

    .blood-icon {
        background: var(--primary-red); 
        color: white; 
        width: 65px; height: 65px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 18px; 
        font-weight: 800; 
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .status-badge { 
        font-size: 0.7rem; 
        padding: 6px 14px; 
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Donor/Hospital Profile Icon */
    .user-icon-box {
        width: 32px;
        height: 32px;
        background: var(--soft-bg);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--deep-navy);
        font-size: 0.9rem;
    }

    .role-badge {
        background: var(--soft-bg);
        color: var(--deep-navy);
        font-size: 0.65rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50px;
    }

    /* Action Buttons */
    .btn-action {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 700;
        transition: 0.3s;
    }

    .empty-state {
        background: white;
        border-radius: 30px;
        padding: 80px 20px;
    }
</style>
@endsection

@section('content')
<section class="hero-search text-center">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3" data-aos="fade-down">Find Life-Saving Blood</h1>
        <p class="lead opacity-75 mb-0" data-aos="fade-up">Connecting everyone with Donors and Hospitals in real-time.</p>
    </div>
</section>

<div class="container search-box-container mb-5">
    <div class="search-card" data-aos="zoom-in" data-aos-delay="200">
        <form action="{{ route('find.blood') }}" method="GET" class="row g-4 align-items-end">
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-bold small text-muted ms-2"><i class="fa-solid fa-droplet text-danger me-1"></i> Blood Group</label>
                <select name="blood_group" class="form-select bg-light custom-input">
                    <option value="">All Groups</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                        <option value="{{ $group }}" {{ request('blood_group') == $group ? 'selected' : '' }}>{{ $group }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4 col-md-6">
                <label class="form-label fw-bold small text-muted ms-2"><i class="fa-solid fa-location-dot text-danger me-1"></i> Location</label>
                <input type="text" name="location" class="form-control bg-light custom-input" placeholder="City or Area Name" value="{{ request('location') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-bold small text-muted ms-2"><i class="fa-solid fa-hospital text-danger me-1"></i> Search Scope</label>
                <select name="type" class="form-select bg-light custom-input">
                    <option value="all">Any Source (All)</option>
                    <option value="donor" {{ request('type') == 'donor' ? 'selected' : '' }}>Individual Donors</option>
                    <option value="hospital" {{ request('type') == 'hospital' ? 'selected' : '' }}>Hospital Stocks</option>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Search Results</h4>
                <small class="text-muted">Available blood sources matching your criteria</small>
            </div>
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                <span class="text-danger fw-bold">{{ $results->total() }}</span> matching results
            </span>
        </div>
        
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
                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <div class="user-icon-box" title="{{ ucfirst($item->role) }}">
                            @if($item->role == 'hospital')
                                <i class="fa-solid fa-hospital"></i>
                            @else
                                <i class="fa-solid fa-user-check"></i>
                            @endif
                        </div>

                        @if($item->role == 'donor')
                            @if($item->last_donation_date)
                                <span class="badge bg-success-subtle text-success border border-success status-badge rounded-pill">
                                    <i class="fa-solid fa-clock-rotate-left me-1"></i> {{ \Carbon\Carbon::parse($item->last_donation_date)->diffForHumans() }}
                                </span>
                            @else
                                <span class="badge bg-info-subtle text-info border border-info status-badge rounded-pill">
                                    <i class="fa-solid fa-heart-pulse me-1"></i> Ready to Donate
                                </span>
                            @endif
                        @else
                            <span class="badge bg-warning-subtle text-dark border border-warning status-badge rounded-pill">
                                <i class="fa-solid fa-house-medical me-1"></i> Hospital Facility
                            </span>
                        @endif
                    </div>
                    
                    <h5 class="fw-bold mb-1">{{ $item->name }}</h5>
                    <p class="text-muted small mb-0">
                        <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $item->address ?? 'Location info not available' }}
                    </p>
                </div>
            </div>
            
            <div class="text-lg-end text-start">
                @if($item->role == 'hospital')
                    @php
                        $stock = \App\Models\BloodStock::where('user_id', $item->id)
                                    ->where('blood_group', request('blood_group'))
                                    ->first();
                    @endphp
                    <div class="mb-3">
                        <span class="h4 fw-bold text-danger mb-0">{{ $stock ? $stock->bags : '0' }}</span> 
                        <span class="text-muted small">Bags in stock</span>
                    </div>
                    <a href="/hospital/request/{{ $item->id }}" class="btn btn-outline-dark btn-action">
                        <i class="fa-solid fa-paper-plane me-2"></i>Request Bags
                    </a>
                @else
                    <div class="mb-3">
                        <span class="text-success fw-bold small">
                            <i class="fa-solid fa-circle-check me-1"></i> Verified Donor
                        </span>
                    </div>
                    <a href="tel:{{ $item->phone }}" class="btn btn-dark btn-action shadow-sm">
                        <i class="fa-solid fa-phone me-2"></i>Contact Now
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state text-center shadow-sm border" data-aos="zoom-in">
            <div class="mb-4">
                <i class="fa-solid fa-droplet-slash display-1 text-muted opacity-25"></i>
            </div>
            <h3 class="fw-bold text-muted">No Matching Donors Found</h3>
            <p class="text-secondary mx-auto mb-4" style="max-width: 500px;">
                We couldn't find any donors matching your criteria at this moment. Donors who have donated in the last 90 days are hidden for safety.
            </p>
            <a href="{{ route('find.blood') }}" class="btn btn-danger px-5">Clear All Filters</a>
        </div>
        @endforelse

        <div class="mt-5 d-flex justify-content-center">
            {{ $results->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>
@endsection