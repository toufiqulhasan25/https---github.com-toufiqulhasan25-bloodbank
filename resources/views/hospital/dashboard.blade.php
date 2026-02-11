@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Success/Error Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notification Section --}}
        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            @foreach($unreadNotifications as $notification)
                <div class="alert {{ $notification->status == 'approved' ? 'alert-info' : 'alert-secondary' }} alert-dismissible fade show border-0 shadow-sm rounded-4 mb-3 d-flex align-items-center notification-alert" role="alert">
                    <i class="fa-solid fa-bell-concierge me-3 fa-lg"></i>
                    <div class="flex-grow-1">
                        <strong>New Update:</strong> Your request for <strong>{{ $notification->blood_group }}</strong> has been <strong>{{ ucfirst($notification->status) }}</strong>.
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        <div class="row">
            {{-- Sidebar: Hospital Info --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-hospital text-danger" style="font-size: 50px;"></i>
                        </div>
                        <h4 class="fw-bold">{{ auth()->user()->name }}</h4>
                        <p class="text-muted small">{{ auth()->user()->email }}</p>
                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold small">Authorized Hospital</span>
                        <hr>
                        <div class="text-start mb-2">
                            <small class="text-muted d-block">Contact Number:</small>
                            <span class="fw-bold text-dark">{{ auth()->user()->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Update Stock Form --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle text-danger me-2"></i>Update Stock</h5>
                        <form action="{{ route('hospital.updateStock') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Blood Group</label>
                                <select name="blood_group" class="form-select border-0 bg-light rounded-3" required>
                                    <option value="" selected disabled>Select Group</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                        <option value="{{ $bg }}">{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Total Bags</label>
                                <input type="number" name="bags" class="form-control border-0 bg-light rounded-3" placeholder="Ex: 5" min="0" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold shadow-sm py-2">Update Inventory</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Dashboard Content --}}
            <div class="col-md-8">
                <h3 class="fw-bold mb-4">Hospital Analytics</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm bg-primary text-white rounded-4 overflow-hidden">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="opacity-75 text-uppercase small fw-bold">Pending Requests</h6>
                                    {{-- কন্ট্রোলার থেকে আসা সরাসরি কাউন্ট --}}
                                    <h2 class="fw-bold mb-0">{{ $pendingCount }}</h2>
                                </div>
                                <i class="fa-solid fa-spinner fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm bg-success text-white rounded-4 overflow-hidden">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="opacity-75 text-uppercase small fw-bold">Total Stock</h6>
                                    <h2 class="fw-bold mb-0">{{ $stocks->sum('bags') }} Bags</h2>
                                </div>
                                <i class="fa-solid fa-boxes-stacked fa-3x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Blood Inventory Table --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">Current Blood Stock</h5>
                        <span class="badge bg-light text-dark rounded-pill px-3 fw-normal border">{{ $stocks->count() }} Groups</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Blood Group</th>
                                        <th>Available Bags</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stocks as $stock)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-danger text-white fw-bold px-3 py-2 rounded-3">{{ $stock->blood_group }}</span>
                                            </td>
                                            <td class="fw-bold text-dark">{{ $stock->bags }} Bags</td>
                                            <td class="text-muted small">{{ $stock->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">No stock added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity Table --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">Recent Blood Requests</h5>
                        {{-- হিস্ট্রি পেজের লিঙ্ক এখানে সেট করা হয়েছে --}}
                        <a href="{{ route('hospital.history') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase text-muted">
                                    <tr>
                                        <th class="ps-4">Patient Name</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th class="pe-4 text-end">Requested On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- এখানে এখন শুধু লেটেস্ট ৫টি ডাটা আসবে --}}
                                    @forelse($requests as $request)
                                        <tr>
                                            <td class="ps-4 fw-medium">{{ $request->patient_name }}</td>
                                            <td><span class="badge bg-danger-subtle text-danger px-2 border border-danger-subtle">{{ $request->blood_group }}</span></td>
                                            <td>
                                                @if($request->status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                                    </span>
                                                @elseif($request->status == 'approved')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                        <i class="fa-solid fa-circle-check me-1"></i> Approved
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-muted px-3 py-2 rounded-pill border">{{ ucfirst($request->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end"><small class="text-muted">{{ $request->created_at->format('d M, Y') }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No recent requests found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script stays the same as per your logic --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let notifications = document.querySelectorAll('.notification-alert');
        if (notifications.length > 0) {
            setTimeout(function() {
                fetch("{{ route('hospital.markRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        notifications.forEach(alert => {
                            let bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        });
                    }
                })
                .catch(error => console.error('Error updating status:', error));
            }, 5000); 
        }
    });
    </script>

    <style>
        .bg-danger-subtle { background-color: #fcf1f2 !important; }
        .bg-success-subtle { background-color: #eef9f5 !important; }
        .bg-warning-subtle { background-color: #fffaf0 !important; }
        .card { transition: all 0.3s ease; }
        .card:hover { transform: translateY(-4px); }
        .notification-alert { transition: opacity 0.5s ease; }
    </style>
@endsection