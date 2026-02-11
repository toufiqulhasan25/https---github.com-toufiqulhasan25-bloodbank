@extends('layouts.app')

@section('title', 'Request History')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Blood Request History</h3>
                <p class="text-muted small">Monitor your previous requests and their statuses</p>
            </div>
            <a href="{{ route('hospital.request.create') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>New Request
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Patient Name</th>
                                <th>Group</th>
                                <th>Bags</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td class="ps-4">{{ $req->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <h6 class="fw-bold mb-0">{{ $req->patient_name }}</h6>
                                    </td>
                                    <td><span class="badge bg-danger rounded-pill">{{ $req->blood_group }}</span></td>
                                    <td>{{ $req->bags_needed }} Bags</td>
                                    <td>
                                        @if($req->status == 'pending')
                                            <span
                                                class="badge bg-warning-subtle text-warning px-3 rounded-pill border border-warning">Pending</span>
                                        @elseif($req->status == 'approved')
                                            <span
                                                class="badge bg-success-subtle text-success px-3 rounded-pill border border-success">Approved</span>
                                        @else
                                            <span
                                                class="badge bg-danger-subtle text-danger px-3 rounded-pill border border-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light  border" title="{{ $req->reason }}">
                                            <a href="{{ route('hospital.request.show', $req->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fa-3x mb-3 opacity-25"></i>
                                        <p>No request records found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    </div>
@endsection