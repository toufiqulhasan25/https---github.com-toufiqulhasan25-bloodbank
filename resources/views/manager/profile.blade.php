@extends('layouts.app')
@section('page_title', 'Admin Profile')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 text-center">
                <div class="card-body p-5">
                    <i class="fa-solid fa-user-tie text-primary mb-3" style="font-size: 60px;"></i>
                    <h4 class="fw-bold">Manager Account</h4>
                    <form action="{{ route('manager.profile.update') }}" method="POST" class="text-start mt-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Admin Name</label>
                            <input type="text" name="name" class="form-control rounded-pill px-3" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Admin Email</label>
                            <input type="email" class="form-control rounded-pill px-3 bg-light" value="{{ $user->email }}" disabled>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">Save Admin Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection