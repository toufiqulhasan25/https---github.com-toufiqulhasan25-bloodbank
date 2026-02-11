@extends('layouts.app')

@section('title', 'Donation History')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold"><i class="fa-solid fa-clock-rotate-left text-danger me-2"></i>My Donation History</h3>
                <p class="text-muted">A record of your life-saving contributions.</p>
            </div>
            <a href="/donor/appointment" class="btn btn-outline-danger shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> New Donation
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-ghost border-0 p-4 bg-danger text-white shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold">You've saved up to {{ $history->where('status', 'approved')->count() * 3 }}
                                lives!</h4>
                            <p class="mb-0 opacity-75">Every donation can save up to 3 lives. Thank you for being a hero,
                                {{ Auth::user()->name }}.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="display-4 fw-bold">
                                {{ str_pad($history->where('status', 'approved')->count(), 2, '0', STR_PAD_LEFT) }}</div>
                            <div class="small text-uppercase">Total Successful Donations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-ghost border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3">#</th>
                                <th>Date & Time</th>
                                <th>Blood Group</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $key => $row)
                                <tr>
                                    <td class="ps-4">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $row->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $row->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td><span class="badge bg-danger px-3">{{ $row->blood_group }}</span></td>
                                    <td>
                                        @if($row->status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pending</span>
                                        @elseif($row->status == 'approved')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Verified</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($row->status == 'approved')
                                            <a href="{{ route('donor.certificate', $row->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-heart-crack fa-3x mb-3"></i>
                                        <p>No donation records found. Start your journey today!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-ghost {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            font-weight: 600;
        }

        .bg-success-subtle {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .bg-warning-subtle {
            background-color: #fffde7;
            color: #f9a825;
        }

        .bg-secondary-subtle {
            background-color: #f5f5f5;
            color: #757575;
        }
    </style>
@endsection