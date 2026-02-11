@extends('layouts.app')

@section('title', 'Blood Inventory Stock')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-danger mb-0">🩸 Blood Inventory Management</h3>
            <p class="text-muted small">Monitor real-time stock levels and expiration dates.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill">
                Total Records: {{ isset($data) ? $data->count() : 0 }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Stock Summary Cards (Requirement: Real-time tracking) --}}
    <div class="row mb-4">
        @isset($stockSummary)
            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                @php 
                    $summary = $stockSummary->where('blood_group', $group)->first();
                    $total = $summary ? $summary->total_units : 0;
                @endphp
                <div class="col-6 col-md-3 col-lg-2 mb-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-2 {{ $total < 5 ? 'bg-danger-subtle border-start border-danger border-4' : 'bg-white' }}">
                        <div class="card-body p-2">
                            <h5 class="fw-bold mb-0 {{ $total < 5 ? 'text-danger' : '' }}">{{ $group }}</h5>
                            <h4 class="fw-bold mb-1">{{ $total }}</h4>
                            <p class="text-muted extra-small mb-0" style="font-size: 0.7rem;">Units</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>

    {{-- Add New Stock Form (Requirement: Issuing and tracking) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle me-1"></i> Add Manual Entry</h6>
            <form action="{{ route('manager.inventory.store') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">Blood Group</label>
                    <select name="blood_group" class="form-select rounded-3" required>
                        <option value="">Select Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">Units (Bags)</label>
                    <input class="form-control rounded-3" type="number" name="units" placeholder="0" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted">Expiry Date</label>
                    <input class="form-control rounded-3" type="date" name="expiry_date" required>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-danger rounded-3 shadow-sm py-2">
                        <i class="fa-solid fa-save me-1"></i> Add to Inventory
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Inventory Details Table (Requirement: Expiration date tracking) --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="fw-bold mb-0">Stock Details & Alerts</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Blood Group</th>
                        <th>Quantity</th>
                        <th>Collected On</th>
                        <th>Expiry Date</th>
                        <th>Status / Alert</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($data)
                        @forelse($data as $row)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($row->expiry_date);
                                $isExpired = $expiryDate->isPast();
                                $isExpiringSoon = !$isExpired && $expiryDate->diffInDays(now()) <= 7;
                            @endphp
                            <tr class="{{ $isExpired ? 'table-danger' : '' }}">
                                <td class="ps-4 fw-bold">
                                    <span class="avatar-sm bg-danger text-white rounded-circle d-inline-block text-center me-2" style="width: 30px; height: 30px; line-height: 30px; font-size: 0.8rem;">
                                        {{ $row->blood_group }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $row->units }} Bags</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $row->created_at->format('d M, Y') }}
                                </td>
                                <td>
                                    <span class="{{ $isExpired ? 'text-danger fw-bold' : ($isExpiringSoon ? 'text-warning fw-bold' : '') }}">
                                        {{ $expiryDate->format('d M, Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($isExpired)
                                        <span class="badge bg-danger rounded-pill"><i class="fa-solid fa-circle-xmark me-1"></i> Expired</span>
                                    @elseif($isExpiringSoon)
                                        <span class="badge bg-warning text-dark rounded-pill"><i class="fa-solid fa-clock me-1"></i> Expiring Soon</span>
                                    @else
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-check-circle me-1"></i> Healthy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open d-block mb-2 fs-2"></i>
                                    No stock data available.
                                </td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .extra-small { font-size: 0.75rem; }
    .table thead th { font-size: 0.8rem; text-transform: uppercase; color: #6c757d; }
</style>
@endsection