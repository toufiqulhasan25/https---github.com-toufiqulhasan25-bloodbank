@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">📊 Donation Analytics & Reports</h3>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Donations by User Role</div>
                <div class="card-body">
                    @foreach($role_reports as $report)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-capitalize text-secondary">{{ $report->role }}s</span>
                            <span class="fw-bold">{{ $report->total }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($report->total / 10) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Donations by Blood Group</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Blood Group</th>
                                <th>Total Donations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group_reports as $group)
                            <tr>
                                <td><span class="badge bg-danger">{{ $group->blood_group }}</span></td>
                                <td>{{ $group->total }} times donated</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection