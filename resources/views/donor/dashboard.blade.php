@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')
    <div class="container-fluid">
        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Donor Dashboard</h3>
                <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Your contribution saves lives.</p>
            </div>
            @if($isEligible)
                <a href="/donor/appointment" class="btn btn-danger px-4 shadow-sm rounded-pill py-2">
                    <i class="fa-solid fa-calendar-plus me-2"></i>Book Appointment
                </a>
            @else
                <button class="btn btn-secondary px-4 shadow-sm rounded-pill py-2" disabled>
                    <i class="fa-solid fa-lock me-2"></i>Next: {{ $nextEligibleDate }}
                </button>
            @endif
        </div>

        {{-- Stats Cards (Dynamic Data) --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 h-100" style="border-left: 5px solid #dc3545 !important;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light-danger text-danger p-3 rounded-circle me-3">
                            <i class="fa-solid fa-droplet fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold uppercase">Total Donations</h6>
                            <h3 class="fw-bold mb-0 text-dark">{{ sprintf('%02d', $total_donations) }} Times</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 h-100" style="border-left: 5px solid #198754 !important;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-light-success text-success p-3 rounded-circle me-3">
                            <i class="fa-solid fa-heart-pulse fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold uppercase">Last Donated</h6>
                            <h3 class="fw-bold mb-0 text-dark">
                                {{ $last_donation ? \Carbon\Carbon::parse($last_donation->date)->format('d M Y') : 'Never' }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 h-100"
                    style="border-left: 5px solid {{ $isEligible ? '#198754' : '#0dcaf0' }} !important;">
                    <div class="d-flex align-items-center">
                        <div
                            class="icon-box {{ $isEligible ? 'bg-light-success text-success' : 'bg-light-info text-info' }} p-3 rounded-circle me-3">
                            <i class="fa-solid fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold uppercase">Status</h6>
                            <h3 class="fw-bold mb-0 text-dark">
                                @if($isEligible)
                                    <span class="text-success">Ready!</span>
                                @else
                                    {{-- এখানে ceil ব্যবহার করে পূর্ণ সংখ্যা নিশ্চিত করুন --}}
                                    <span class="text-info">{{ ceil($daysUntilNext) }} Days Left</span>
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Eligibility Alert --}}
                @if(!$isEligible)
                    <div class="alert alert-info border-0 shadow-sm rounded-4 p-4 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-info fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Medical Waiting Period</h6>
                                <p class="mb-0 small">According to medical guidelines, you need to wait 90 days between
                                    donations. You will be eligible again on <strong>{{ $nextEligibleDate }}</strong>.</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Recent Activity Table --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Recent History</h5>
                        <a href="/donor/history" class="btn btn-sm btn-outline-danger rounded-pill px-3">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small fw-bold text-muted">DATE</th>
                                        <th class="small fw-bold text-muted">HOSPITAL</th>
                                        <th class="small fw-bold text-muted">STATUS</th>
                                        <th class="text-end pe-4 small fw-bold text-muted">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // আপনি যদি index মেথডে অ্যাপয়েন্টমেন্ট লিস্ট না পাঠিয়ে থাকেন, তবে এটি history মেথড থেকে আনতে পারেন
                                        $recent = \App\Models\Appointment::where('user_id', auth()->id())->latest()->take(3)->get();
                                    @endphp
                                    @forelse($recent as $app)
                                                                <tr>
                                                                    <td class="ps-4 fw-bold small">
                                                                        {{ \Carbon\Carbon::parse($app->date)->format('d M, Y') }}</td>
                                                                    <td class="small">{{ $app->hospital->name ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge rounded-pill px-3 py-2 
                                                                            {{ $app->status == 'approved' ? 'bg-success-subtle text-success' :
                                        ($app->status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                                                            {{ ucfirst($app->status) }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-end pe-4">
                                                                        <button class="btn btn-sm btn-light rounded-pill px-3 border">Details</button>
                                                                    </td>
                                                                </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted small">No recent appointments
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Section --}}
            <div class="col-lg-4">
                <div class="card border-0 bg-dark text-white p-4 mb-4 rounded-4 shadow-sm">
                    <h5 class="fw-bold"><i class="fa-solid fa-lightbulb text-warning me-2"></i>Health Tip</h5>
                    <p class="small mb-0 opacity-75">Drink at least 500ml of water and avoid heavy lifting for 24 hours
                        after donation. Your recovery is as important as your donation!</p>
                </div>

                <div class="card border-0 shadow-sm p-4 text-center rounded-4 h-100">
                    <i class="fa-solid fa-medal text-warning fa-3x mb-3"></i>
                    <h5 class="fw-bold mb-1">Donor Badge</h5>
                    <p class="text-muted small">
                        @if($total_donations >= 5) Platinum @elseif($total_donations >= 2) Gold @else Silver @endif Member
                    </p>
                    <div class="progress rounded-pill mb-3" style="height: 10px; background-color: #eee;">
                        <div class="progress-bar bg-danger" style="width: {{ min(($total_donations / 10) * 100, 100) }}%">
                        </div>
                    </div>
                    <small class="text-muted d-block">Next Milestone: {{ 10 - ($total_donations % 10) }} more to go!</small>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-light-danger {
            background-color: #fff5f5;
        }

        .bg-light-success {
            background-color: #f0fff4;
        }

        .bg-light-info {
            background-color: #e6f7ff;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
        }

        .bg-danger-subtle {
            background-color: #f8d7da !important;
        }

        .extra-small {
            font-size: 0.75rem;
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection