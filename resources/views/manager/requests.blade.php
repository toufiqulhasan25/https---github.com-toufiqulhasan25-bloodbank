@extends('layouts.app')

@section('title', 'Requests')

@section('content')
    <h3 class="mb-3">Blood Requests</h3>
    <div class="card card-ghost p-3">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hospital</th>
                        <th>Blood</th>
                        <th>Units</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $r)
                        <tr>
                            <td>{{ $r->hospital_name }}</td>
                            <td>{{ $r->blood_group }}</td>
                            <td>{{ $r->units }}</td>
                            <td><span <td>
                                    <span
                                        class="badge bg-{{ $r->status == 'pending' ? 'warning' : ($r->status == 'approved' ? 'success' : 'secondary') }}">{{ ucfirst($r->status) }}</span>
                                    <span class="d-none status-text">{{ strtolower($r->status) }}</span>
                            </td>
                            </td>
                            <td>
                                @if($r->status == 'pending')
                                    <form method="POST" action="/manager/requests/{{ $r->id }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection