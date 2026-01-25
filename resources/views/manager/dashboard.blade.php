@extends('layouts.app')

@section('content')
<h1>🩸 Blood Bank Management</h1>

<div style="display:flex;gap:20px">
    <a href="/manager/inventory">Inventory</a>
    <a href="/manager/requests">Requests</a>
    <a href="/manager/appointments">Appointments</a>
    <a href="/manager/reports">Reports</a>
    <a href="/manager/expiry-alerts">Expiry Alerts</a>
</div>

@endsection
