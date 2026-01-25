@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <h3 class="mb-3">System Reports</h3>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-ghost p-3">
                <h6 class="mb-2">Monthly Requests</h6>
                <canvas id="requestsChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-ghost p-3">
                <h6 class="mb-2">Monthly Appointments</h6>
                <canvas id="appointmentsChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-ghost p-3">
                <h6 class="mb-2">Stock Distribution</h6>
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const req = @json($monthlyRequests ?? []);
        const app = @json($monthlyAppointments ?? []);
        const stock = @json($stock ?? []);

        new Chart(document.getElementById('requestsChart'), {
            type: 'bar',
            data: { labels: Object.keys(req), datasets: [{ label: 'Requests', data: Object.values(req), backgroundColor: '#ff6384' }] }
        });

        new Chart(document.getElementById('appointmentsChart'), {
            type: 'line',
            data: { labels: Object.keys(app), datasets: [{ label: 'Appointments', data: Object.values(app), borderColor: '#36a2eb', fill: false }] }
        });

        new Chart(document.getElementById('stockChart'), {
            type: 'pie',
            data: { labels: Object.keys(stock), datasets: [{ label: 'Stock', data: Object.values(stock), backgroundColor: ['#ffcd56', '#4bc0c0', '#9966ff', '#ff6384'] }] }
        });
    </script>

@endsection