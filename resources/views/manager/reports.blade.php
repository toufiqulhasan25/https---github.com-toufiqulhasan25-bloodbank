@extends('layouts.app')

@section('title', 'Analytics & Reports')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">📊 Donation Analytics & Reports</h3>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="window.print()">
            <i class="fa-solid fa-print me-1"></i> Print Report
        </button>
    </div>

    {{-- Top Summary Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-danger text-white">
                <small class="text-uppercase fw-bold opacity-75">Total Successful Donations</small>
                <h2 class="fw-bold mb-0">{{ $total_donations }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white">
                <small class="text-uppercase fw-bold opacity-75">Active Requests</small>
                <h2 class="fw-bold mb-0">{{ $request_stats->where('status', 'pending')->first()->total ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-dark text-white">
                <small class="text-uppercase fw-bold opacity-75">Total Units in Stock</small>
                <h2 class="fw-bold mb-0">{{ $inventory_report->sum('total_units') }} Units</h2>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Real-time Inventory Levels --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-warehouse me-2 text-danger"></i>Current Blood Inventory (Real-time)
                </div>
                <div class="card-body">
                    @foreach($inventory_report as $inv)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold text-dark">Group {{ $inv->blood_group }}</span>
                            <span class="text-muted small">{{ $inv->total_units }} Units</span>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: {{ min(($inv->total_units / 50) * 100, 100) }}%" 
                                 title="{{ $inv->total_units }} Units">
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($inventory_report->isEmpty())
                        <p class="text-center text-muted my-4">No stock available in inventory.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Blood Group Distribution (Donation History) --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-chart-pie me-2 text-primary"></i>Donation Frequency by Group
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th class="ps-4">Blood Group</th>
                                <th>Total Times Donated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($group_reports as $group)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-3 fw-bold">
                                        {{ $group->blood_group }}
                                    </span>
                                </td>
                                <td class="fw-medium text-dark">{{ $group->total }} times</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">No donation history found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection