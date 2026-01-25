@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Blood Inventory</h3>
        <small class="text-muted">Total groups: {{ count($data) }}</small>
    </div>

    <div class="card card-ghost p-3 mb-4">
        <form method="POST" class="row g-2">
            @csrf
            <div class="col-md-4"><input class="form-control" name="blood_group" placeholder="Blood Group (e.g., A+)"></div>
            <div class="col-md-3"><input class="form-control" type="number" name="units" placeholder="Units"></div>
            <div class="col-md-3"><input class="form-control" type="date" name="expiry_date"></div>
            <div class="col-md-2 d-grid"><button class="btn btn-danger">Add</button></div>
        </form>
    </div>

    <div class="card card-ghost p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Blood</th>
                        <th>Units</th>
                        <th>Expiry</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $row->blood_group }}</td>
                            <td>{{ $row->units }}</td>
                            <td>{{ $row->expiry_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection