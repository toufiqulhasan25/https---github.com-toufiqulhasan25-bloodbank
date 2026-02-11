@extends('layouts.app')

@section('page_title', 'My Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <i class="fa-solid fa-circle-user text-secondary" style="font-size: 80px;"></i>
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-danger border border-white border-3" style="font-size: 14px;">
                                {{ auth()->user()->blood_group ?? 'N/A' }}
                            </span>
                        </div>
                        <h4 class="fw-bold mt-3 mb-1">{{ auth()->user()->name }}</h4>
                        <p class="text-muted">{{ ucfirst(auth()->user()->role) }} | NIYD Blood Bank</p>
                    </div>

                    <form action="{{ route('donor.profile.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-pill px-3" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control rounded-pill px-3 bg-light" value="{{ auth()->user()->email }}" disabled>
                                <small class="text-muted ps-2">Email cannot be changed.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="text" name="phone" class="form-control rounded-pill px-3" value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Donation Date</label>
                                <input type="date" name="last_donation_date" class="form-control rounded-pill px-3" value="{{ auth()->user()->last_donation_date }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" class="form-control rounded-4 px-3" rows="3">{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection