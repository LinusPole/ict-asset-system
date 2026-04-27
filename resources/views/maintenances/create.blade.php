@extends('adminlte::page')

@section('title', 'Add Maintenance Record')

@section('content_header')
    <h1>Add Maintenance Record</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="/maintenances">
            @csrf

            <div class="form-group mb-3">
                <label>Select Asset</label>
                <select name="asset_id" class="form-control" required>
                    <option value="">-- Select Asset --</option>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}">
                            {{ $asset->name }} — {{ $asset->serial_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Issue Reported</label>
                <input type="text" name="issue_reported" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Technician Assigned</label>
                <input type="text" name="technician_assigned" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                    <option>Rejected</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Repair Cost</label>
                <input type="number" step="0.01" name="repair_cost" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Reported Date</label>
                <input type="date" name="reported_date" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Completed Date</label>
                <input type="date" name="completed_date" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label>Remarks</label>
                <textarea name="remarks" class="form-control" rows="4"></textarea>
            </div>

            <button class="btn btn-success">
                Save Maintenance Record
            </button>

            <a href="/maintenances" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop