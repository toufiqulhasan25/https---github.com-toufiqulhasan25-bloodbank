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

        {{-- NEW: Real-time Blood Requests/Notifications --}}
        @foreach($notifications->where('is_read', false) as $notification)
            <div
                class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4 d-flex justify-content-between align-items-center animate__animated animate__pulse animate__infinite">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-danger rounded-circle p-2 me-3 shadow-sm">
                        <i class="fa-solid fa-bell-exclamation"></i>
                    </div>
                    <div>
                        <strong class="d-block">Urgent Blood Request!</strong>
                        <span class="small">{{ $notification->sender_name }} {{ $notification->message }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <small class="text-muted me-2 align-self-center">{{ $notification->created_at->diffForHumans() }}</small>
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">Mark as Seen</button>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-0">Donor Dashboard</h3>
                <p class="text-muted mb-0">Welcome, {{ auth()->user()->name }}! Your contribution saves lives.</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-dark px-4 rounded-pill py-2 shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#updateDonationModal">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Update Last Donation
                </button>
                <a href="{{ route('donor.card') }}" class="btn btn-outline-danger px-4 rounded-pill py-2 shadow-sm">
                    <i class="fa-solid fa-id-card me-2"></i>My Donor Card
                </a>

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
        </div>

        {{-- Stats Cards --}}
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
                                {{ auth()->user()->last_donation_date ? \Carbon\Carbon::parse(auth()->user()->last_donation_date)->format('d M Y') : 'Never' }}
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
                                    <span class="text-success">Ready to Save!</span>
                                @else
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
                {{-- Recent Activity Table --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
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
                                        $recent = \App\Models\Appointment::with('hospital')->where('user_id', auth()->id())->latest()->take(3)->get();
                                    @endphp
                                    @forelse($recent as $app)
                                        <tr>
                                            <td class="ps-4 fw-bold small">
                                                {{ \Carbon\Carbon::parse($app->date)->format('d M, Y') }}</td>
                                            <td class="small">{{ $app->hospital->name ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill px-3 py-2 
                                                            {{ $app->status == 'approved' ? 'bg-success-subtle text-success' : ($app->status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ url('/donor/appointments/'.$app->id) }}" class="btn btn-sm btn-light rounded-pill px-3 border">Details</a>
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

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Donor Rank / Medal --}}
                <div class="card border-0 shadow-sm p-4 text-center rounded-4 mb-4 h-100">
                    <div class="rank-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 80px; height: 80px; background: #fff; border-radius: 50%; border: 4px solid {{ $total_donations >= 5 ? '#ffd700' : '#c0c0c0' }};">
                        <i
                            class="fa-solid fa-medal {{ $total_donations >= 5 ? 'text-warning' : 'text-secondary' }} fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Donor Rank</h5>
                    <p class="text-muted small">
                        @if($total_donations >= 5) Platinum @elseif($total_donations >= 2) Gold @else Silver @endif Member
                    </p>
                    <div class="progress rounded-pill mb-3" style="height: 10px; background-color: #eee;">
                        <div class="progress-bar bg-danger" style="width: {{ min(($total_donations / 10) * 100, 100) }}%">
                        </div>
                    </div>
                    <small class="text-muted">Next Rank: {{ 10 - ($total_donations % 10) }} donations left</small>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Update Last Donation Date --}}
    <div class="modal fade" id="updateDonationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0">
                    <h5 class="fw-bold mb-0">Update Last Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('donor.profile.update') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <p class="text-muted small">Setting your last donation date correctly helps people find you when you
                            are eligible.</p>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">When was your last donation?</label>
                            <input type="date" name="last_donation_date" class="form-control rounded-3"
                                value="{{ auth()->user()->last_donation_date }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">Update Now</button>
                    </div>
                </form>
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

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
    </style>
@endsection