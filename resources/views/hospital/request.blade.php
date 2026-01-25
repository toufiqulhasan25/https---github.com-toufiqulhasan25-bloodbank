@extends('layouts.app')

@section('title', 'Request Blood')

@section('content')
    <div class="card card-ghost p-3">
        <h4 class="mb-3">Request Blood</h4>
        @if(session('success') || isset($success))
            <div class="alert alert-success" data-test="flash-success">{{ session('success') ?? $success }}</div>
        @endif
        <form method="POST" action="/hospital/request">
            @csrf
            <div class="mb-3">
                <label class="form-label">Hospital Name</label>
                <input name="hospital_name" class="form-control" required>
            </div>
            <div class="row g-2">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Blood Group</label>
                    <input name="blood_group" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Units</label>
                    <input name="units" type="number" class="form-control" required>
                </div>
            </div>
            <button class="btn btn-primary">Submit Request</button>
        </form>
    </div>
@endsection