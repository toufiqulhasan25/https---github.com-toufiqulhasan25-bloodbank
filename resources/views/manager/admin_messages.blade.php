@extends('layouts.frontend') 
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-dark-blue">Contact Messages</h2>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Contact Info</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $msg)
                    <tr>
                        <td>{{ $msg->created_at->format('d M, Y') }}</td>
                        <td class="fw-bold">{{ $msg->name }}</td>
                        <td>{{ $msg->contact_info }}</td>
                        <td>{{ $msg->message }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection