@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <h3 class="mb-3">Appointments</h3>
    <div class="card card-ghost p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Donor</th>
                        <th>Blood</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apps as $a)
                        <tr>
                            <td>{{ $a->donor_name }}</td>
                            <td>{{ $a->blood_group }}</td>
                            <td>{{ $a->date }}</td>
                            <td>{{ $a->time }}</td>
                            <td><span
                                    class="badge bg-{{ $a->status == 'pending' ? 'warning' : ($a->status == 'approved' ? 'success' : 'secondary') }}">{{ ucfirst($a->status) }}</span>
                            </td>
                            <td>
                                @if($a->status == 'pending')
                                    <form method="POST" action="/manager/appointments/{{ $a->id }}">
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