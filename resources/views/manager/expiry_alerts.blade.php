@extends('layouts.app')

@section('title', 'Expiry Alerts')

@section('content')
    <h3 class="mb-3">Expiring Blood Stock</h3>
    <div class="card card-ghost p-3">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Blood Group</th>
                        <th>Units</th>
                        <th>Expiry</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alerts as $a)
                        <tr>
                            <td>{{ $a->blood_group }}</td>
                            <td>{{ $a->units }}</td>
                            <td>{{ $a->expiry_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection