@extends('adminlte::page')

@section('title', 'Maintenance Records')

@section('content_header')
    <h1>Maintenance Management</h1>
@stop

@section('content')

<a href="/maintenances/create" class="btn btn-primary mb-3">
    + Add Maintenance Record
</a>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Issue</th>
                    <th>Reported By</th>
                    <th>Technician</th>
                    <th>Status</th>
                    <th>Repair Cost</th>
                    <th>Reported Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($maintenances as $maintenance)
                <tr>
                    <td>{{ $maintenance->asset->name }}</td>
                    <td>{{ $maintenance->issue_reported }}</td>
                    <td>{{ $maintenance->reported_by }}</td>
                    <td>{{ $maintenance->technician_assigned }}</td>
                    <td>{{ $maintenance->status }}</td>
                    <td>KES {{ $maintenance->repair_cost }}</td>
                    <td>{{ $maintenance->reported_date }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No maintenance records found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@stop