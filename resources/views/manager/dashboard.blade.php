@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('page_title', 'Manager Portal') {{-- এটি টপ-বারে দেখাবে --}}

@section('content')
<div class="container-fluid px-4 py-3">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Manager Portal</h3>
            <p class="text-muted small mb-0">NIYD Blood Bank Central Monitoring System</p>
        </div>
        <div class="text-end">
            <span class="badge bg-danger p-2 px-3 rounded-3 shadow-sm">
                <i class="fa-solid fa-calendar-day me-1"></i> {{ date('d M, Y') }}
            </span>
        </div>
    </div>

    {{-- Quick Action Cards (Icons) --}}
    <div class="row row-cols-2 row-cols-md-5 g-3 mb-4">
        @php
            $navs = [
                ['url' => '/manager/inventory', 'icon' => 'fa-warehouse', 'label' => 'Inventory', 'color' => '#BE1E2D'],
                ['url' => '/manager/requests', 'icon' => 'fa-hospital', 'label' => 'Requests', 'color' => '#007bff'],
                ['url' => '/manager/appointments', 'icon' => 'fa-calendar-check', 'label' => 'Appointments', 'color' => '#ffc107'],
                ['url' => '/manager/reports', 'icon' => 'fa-file-lines', 'label' => 'Reports', 'color' => '#28a745'],
                ['url' => '/manager/expiry-alerts', 'icon' => 'fa-triangle-exclamation', 'label' => 'Expiry', 'color' => '#343a40'],
            ];
        @endphp
        @foreach($navs as $nav)
        <div class="col">
            <a href="{{ $nav['url'] }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center p-3 h-100 quick-nav">
                    <div class="icon-box mb-2 mx-auto">
                        <i class="fa-solid {{ $nav['icon'] }} fs-4" style="color: {{ $nav['color'] }}"></i>
                    </div>
                    <span class="small fw-bold text-dark">{{ $nav['label'] }}</span>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Stats Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small opacity-75 fw-bold">Total Blood Stock</h6>
                    <h1 class="display-5 fw-bold mb-0">{{ $total_units ?? 0 }} <span class="fs-4 fw-normal">Bags</span></h1>
                    <i class="fa-solid fa-droplet position-absolute end-0 bottom-0 mb-n3 me-n2 opacity-25" style="font-size: 7rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white border-start border-warning border-5 h-100">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-muted fw-bold">Pending Appointments</h6>
                    <h1 class="display-5 fw-bold text-dark mb-1">{{ $pending_appts ?? 0 }}</h1>
                    <div class="text-warning small fw-bold">
                        <i class="fa-solid fa-circle-exclamation me-1"></i> Action Required
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-white border-start border-info border-5 h-100">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small text-muted fw-bold">Hospital Requests</h6>
                    <h1 class="display-5 fw-bold text-dark mb-1">{{ $pending_requests ?? 0 }}</h1>
                    <div class="text-info small fw-bold">
                        <i class="fa-solid fa-truck-fast me-1"></i> Delivery Pending
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stock Analysis Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-bar me-2 text-danger"></i>Current Stock Analysis</h5>
            <button class="btn btn-light btn-sm border fw-bold text-muted"><i class="fa-solid fa-rotate me-1"></i> Refresh</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Group</th>
                        <th class="border-0">Available Stock</th>
                        <th class="border-0">Stock Level</th>
                        <th class="border-0">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold fs-5 text-danger">{{ $item->blood_group }}</span>
                        </td>
                        <td><span class="fw-bold">{{ $item->units }}</span> Bags</td>
                        <td style="width: 35%;">
                            @php
                                $percent = min(($item->units / 20) * 100, 100);
                                $color = $item->units <= 2 ? 'bg-danger' : ($item->units <= 5 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress rounded-pill" style="height: 10px;">
                                <div class="progress-bar {{ $color }} rounded-pill" role="progressbar" style="width: {{ $percent }}%"></div>
                            </div>
                        </td>
                        <td>
                            @if($item->units <= 2)
                                <span class="badge bg-danger px-3 py-2 w-75">CRITICAL</span>
                            @elseif($item->units <= 5)
                                <span class="badge bg-warning text-dark px-3 py-2 w-75">LOW</span>
                            @else
                                <span class="badge bg-success px-3 py-2 w-75">HEALTHY</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">No Data Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* মডার্ন কুইক নেভ কার্ড */
    .quick-nav {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent !important;
    }
    .quick-nav:hover {
        transform: translateY(-5px);
        background: #fff;
        border-color: #BE1E2D !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .icon-box {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: 0.3s;
    }
    .quick-nav:hover .icon-box {
        background: #BE1E2D;
    }
    .quick-nav:hover .icon-box i {
        color: white !important;
    }
    
    /* টেবিল স্টাইলিং */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #888;
        padding: 15px 10px;
    }
    .table tbody td {
        padding: 18px 10px;
        border-bottom: 1px solid #f2f2f2;
    }
    .progress { background-color: #f0f2f5; }
</style>
@endsection