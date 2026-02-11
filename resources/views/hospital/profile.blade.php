@extends('layouts.app')
@section('page_title', 'Hospital Profile')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <i class="fa-solid fa-hospital text-danger mb-3" style="font-size: 60px;"></i>
                    <h4 class="fw-bold">Hospital Details</h4>
                    <form action="{{ route('hospital.profile.update') }}" method="POST" class="text-start mt-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hospital Name</label>
                            <input type="text" name="name" class="form-control rounded-pill px-3" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="phone" class="form-control rounded-pill px-3" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Location/Address</label>
                            <textarea name="address" class="form-control rounded-4" rows="3">{{ $user->address }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 mt-3 shadow-sm">Update Hospital Info</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection