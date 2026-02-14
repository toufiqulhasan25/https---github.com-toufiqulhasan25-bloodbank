@extends('layouts.app')

@section('title', 'Analytics & Reports')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">📊 Donation Analytics & Reports</h3>
        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 shadow-sm" onclick="window.print()">
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
                <small class="text-uppercase fw-bold opacity-75">Total Units Distributed</small>
                <h2 class="fw-bold mb-0">{{ $request_stats->sum('total') }}</h2>
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
        {{-- Chart 1: Real-time Inventory Levels (Bar Chart) --}}
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white fw-bold py-3 border-0">
                    <i class="fa-solid fa-chart-bar me-2 text-danger"></i>Inventory Stock Analysis
                </div>
                <div class="card-body">
                    <canvas id="inventoryChart" style="min-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        {{-- Chart 2: Donation Frequency (Pie Chart) --}}
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white fw-bold py-3 border-0">
                    <i class="fa-solid fa-chart-pie me-2 text-primary"></i>Donation Frequency Mix
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="donationPieChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recipient Analysis Table --}}
    <div class="card shadow-sm border-0 rounded-4 mt-2">
        <div class="card-header bg-white fw-bold py-3">
            <i class="fa-solid fa-truck-ramp-box me-2 text-success"></i>Hospital Distribution Analysis
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Hospital Name</th>
                        <th>Total Units Received</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($request_stats as $stat)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-light rounded-circle p-2 me-2 text-center" style="width:35px">
                                    <i class="fa-solid fa-hospital text-primary"></i>
                                </div>
                                <span class="fw-bold">{{ $stat->hospital_name }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary px-3">{{ $stat->total }} Units</span></td>
                        <td><span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Fulfilled</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-4 text-muted">No distribution data found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Scripts for Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Inventory Bar Chart Logic
    const invCtx = document.getElementById('inventoryChart').getContext('2d');
    new Chart(invCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($inventory_report->pluck('blood_group')) !!},
            datasets: [{
                label: 'Units in Stock',
                data: {!! json_encode($inventory_report->pluck('total_units')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: '#dc3545',
                borderWidth: 2,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // 2. Donation Pie Chart Logic
    const pieCtx = document.getElementById('donationPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut', // 'pie' ও ব্যবহার করতে পারেন, 'doughnut' দেখতে বেশি মডার্ন
        data: {
            labels: {!! json_encode($group_reports->pluck('blood_group')) !!},
            datasets: [{
                data: {!! json_encode($group_reports->pluck('total')) !!},
                backgroundColor: [
                    '#dc3545', '#0d6efd', '#198754', '#ffc107', 
                    '#0dcaf0', '#6610f2', '#fd7e14', '#20c997'
                ],
                hoverOffset: 10,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });
</script>

<style>
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .card { transition: transform 0.2s; border: none !important; }
    @media print {
        .btn, .sidebar, .navbar { display: none !important; }
        canvas { max-width: 100% !important; }
    }
</style>
@endsection