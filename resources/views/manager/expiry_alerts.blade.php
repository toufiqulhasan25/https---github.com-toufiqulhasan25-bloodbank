@extends('layouts.app')

@section('title', 'Expiry Alerts')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Expiry Alerts</h3>
        <a href="/manager/inventory" class="btn btn-secondary btn-sm">Back to Inventory</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Blood Group</th>
                        <th>Units</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expired as $item)
                    <tr class="{{ \Carbon\Carbon::parse($item->expiry_date)->isPast() ? 'table-danger' : 'table-warning' }}">
                        <td class="ps-4 fw-bold">{{ $item->blood_group }}</td>
                        <td>{{ $item->units }} Bags</td>
                        <td>{{ \Carbon\Carbon::parse($item->expiry_date)->format('d M, Y') }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($item->expiry_date)->isPast())
                                <span class="badge bg-danger">Expired</span>
                            @else
                                <span class="badge bg-dark">Expiring Soon</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-circle-check text-success fa-2x mb-3"></i>
                            <p>Great! No blood units are expiring soon.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection