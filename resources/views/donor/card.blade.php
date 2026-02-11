@extends('layouts.app')

@section('title', 'My Donor Card')

@section('content')
<div class="container py-5 d-flex flex-column align-items-center">
    <div class="donor-card-wrapper shadow-lg mb-4" id="printableCard">
        {{-- Card Header --}}
        <div class="card-top">
            <div class="d-flex justify-content-between align-items-start px-4 pt-4">
                <div class="text-white">
                    <h4 class="fw-bold mb-0">NIYD BLOOD BANK</h4>
                    <p class="small opacity-75">Saves Lives, Spreads Love</p>
                </div>
                <div class="blood-group-badge shadow-sm">
                    {{ $user->blood_group }}
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="card-main p-4 bg-white">
            <div class="row">
                <div class="col-4">
                    <div class="photo-placeholder shadow-sm">
                        <i class="fa-solid fa-user-circle fa-5x text-secondary"></i>
                    </div>
                </div>
                <div class="col-8 text-start">
                    <h3 class="fw-bold text-dark mb-1">{{ strtoupper($user->name) }}</h3>
                    <p class="mb-1 text-muted"><i class="fa-solid fa-id-badge me-2"></i>ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-1 text-muted"><i class="fa-solid fa-phone me-2"></i>{{ $user->phone }}</p>
                    <p class="mb-0 text-muted small"><i class="fa-solid fa-calendar-check me-2"></i>Total Donations: {{ $total_donations }}</p>
                </div>
            </div>
            
            <hr class="my-4 opacity-25">

            <div class="d-flex justify-content-between align-items-end">
                <div class="status-box">
                    <span class="d-block small text-muted text-uppercase fw-bold">Status</span>
                    <span class="badge bg-success-subtle text-success border border-success px-3 rounded-pill">VERIFIED DONOR</span>
                </div>
                <div class="qr-box">
                    {{-- প্যাকেজ ইনস্টল থাকলে নিচের কোডটি কাজ করবে --}}
                    {!! QrCode::size(60)->generate(url('/profile/'.$user->id)) !!}
                </div>
            </div>
        </div>
        <div class="card-footer-red"></div>
    </div>

    {{-- Buttons --}}
    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm me-2">
            <i class="fa-solid fa-print me-2"></i>Print Card
        </button>
        <a href="{{ route('donor.dashboard') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
            <i class="fa-solid fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<style>
    .donor-card-wrapper {
        width: 420px;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        position: relative;
    }
    .card-top {
        background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
        height: 140px;
    }
    .blood-group-badge {
        background: white;
        color: #dc3545;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.4rem;
    }
    .photo-placeholder {
        width: 100%;
        aspect-ratio: 1/1;
        background: #f8f9fa;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #eee;
    }
    .card-footer-red {
        height: 15px;
        background: #dc3545;
    }
    @media print {
        .d-print-none { display: none; }
        body { background: white; }
        .donor-card-wrapper { box-shadow: none !important; border: 1px solid #ddd; }
    }
</style>
@endsection