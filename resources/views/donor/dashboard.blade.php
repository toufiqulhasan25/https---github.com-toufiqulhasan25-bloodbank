@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')
    <div class="container-fluid">
        {{-- Eligibility Summary Alert --}}
        <div class="row mb-4">
            <div class="col-12">
                @if($isEligible)
                    <div
                        class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-3 animate__animated animate__fadeInDown">
                        <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">You are eligible to donate!</h6>
                            <small>Help save lives by booking an appointment today.</small>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center p-3">
                        <i class="fa-solid fa-clock-rotate-left fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Next Donation Eligibility</h6>
                            <small>Based on your last donation, you will be eligible again on
                                <strong>{{ $nextEligibleDate }}</strong> ({{ ceil($daysUntilNext) }} days left).</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Notifications Section --}}
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
                    <a href="{{ url('/donor/appointment') }}" class="btn btn-danger px-4 shadow-sm rounded-pill py-2">
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
            {{-- Main Content: Recent Activity --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Recent History</h5>
                        <a href="{{ url('/donor/history') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">View
                            All</a>
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
                                                {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M, Y') }}
                                            </td>
                                            <td class="small">{{ $app->hospital->name ?? 'Blood Center' }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill px-3 py-2 
                                                            {{ $app->status == 'approved' ? 'bg-success-subtle text-success' : ($app->status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ url('/donor/appointments/' . $app->id) }}"
                                                    class="btn btn-sm btn-light rounded-pill px-3 border">Details</a>
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

            {{-- Sidebar: Rank & Quotes --}}
            <div class="col-lg-4">
                {{-- Rank Card --}}
                <div class="card border-0 shadow-sm p-4 text-center rounded-4 mb-4">
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

                {{-- Daily Quote Section --}}
                <div class="card border-0 shadow-sm p-4 rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #BE1E2D, #961824); color: white;">
                    @php
                        $quotes = [
                            "Your blood is precious: Donate, save a life and make it divine.",
                            "A life may be a drop of help for you, but it’s a million miracles for those in need.",
                            "The blood donor of today may be a recipient of tomorrow.",
                            "Donating blood is the best way to say 'I care' without using words.",
                            "Excuses never save a life, but blood donation does.",
                            "Every blood donor is a hero. Be someone's hero today.",
                            "One unit of blood can save up to three lives. You are a lifesaver!"
                        ];
                        $dailyQuote = $quotes[date('z') % count($quotes)]; 
                    @endphp

                    <div class="d-flex align-items-start">
                        <i class="fa-solid fa-quote-left fs-4 me-3 opacity-50"></i>
                        <div>
                            <h6 class="fw-bold mb-2 uppercase" style="font-size: 11px; letter-spacing: 1px;">Daily
                                Inspiration</h6>
                            <p class="mb-0 font-italic" style="font-size: 14px; line-height: 1.6;">
                                "{{ $dailyQuote }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS Styles --}}
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
                        <p class="text-muted small">Setting your last donation date correctly helps maintain your
                            eligibility status.</p>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">When was your last donation?</label>
                            <input type="date" name="last_donation_date" class="form-control rounded-3"
                                value="{{ auth()->user()->last_donation_date ? \Carbon\Carbon::parse(auth()->user()->last_donation_date)->format('Y-m-d') : '' }}"
                                max="{{ date('Y-m-d') }}" required>
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
@endsection