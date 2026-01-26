@extends('layouts.app')

@section('title', 'Blood Inventory')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 text-danger font-weight-bold">🩸 Blood Inventory Stock</h3>
        {{-- এখানে @isset ব্যবহার করা হয়েছে যাতে $data না থাকলেও এরর না দেয় --}}
        <small class="text-muted">Total groups: {{ isset($data) ? count($data) : 0 }}</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm p-3 mb-4 bg-light">
        <form action="{{ url('/manager/inventory') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-3">
                <label class="small fw-bold">Blood Group</label>
                <select name="blood_group" class="form-select" required>
                    <option value="">Select Group</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $g)
                        <option value="{{ $g }}">{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="small fw-bold">Units (Bags)</label>
                <input class="form-control" type="number" name="units" placeholder="Units" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="small fw-bold">Expiry Date</label>
                <input class="form-control" type="date" name="expiry_date" required>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-danger shadow-sm">Add to Stock</button>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Blood Group</th>
                        <th>Units Available</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($data)
                        @forelse($data as $row)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $row->blood_group }}</td>
                                <td>
                                    <span class="badge {{ $row->units < 3 ? 'bg-warning text-dark' : 'bg-info' }}">
                                        {{ $row->units }} Bags
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->expiry_date)->format('d M, Y') }}</td>
                                <td>
                                    @if(\Carbon\Carbon::parse($row->expiry_date)->isPast())
                                        <span class="text-danger small"><i class="fa fa-exclamation-circle"></i> Expired</span>
                                    @else
                                        <span class="text-success small">Fresh</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No stock data found in inventory.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
@endsection