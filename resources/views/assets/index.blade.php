@extends('adminlte::page')

@section('title', 'Kilifi County Asset Governance System')

@section('content_header')
    <h1>ICT Asset Management Dashboard</h1>
@stop

@section('content')

<div class="container-fluid">

    <!-- Welcome -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Welcome, {{ auth()->user()->name }}</h4>

        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="mb-4 d-flex flex-wrap gap-2 align-items-start">

        <a href="/assets/create" class="btn btn-primary" style="min-width: 180px;">
            + Add Asset
        </a>

        <form method="GET" action="/assets/report/pdf" class="d-flex gap-2">

            <select name="department" class="form-control" style="min-width: 220px;" required>
                <option value="">-- Select Department --</option>
                <option value="ICT">ICT</option>
                <option value="Health">Health</option>
                <option value="Finance">Finance</option>
                <option value="Roads">Roads</option>
                <option value="Water">Water</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Education">Education</option>
                <option value="Administration">Administration</option>
                <option value="Tourism">Tourism</option>
            </select>

            <button type="submit" class="btn btn-danger" style="min-width: 180px;">
                Generate PDF
            </button>

        </form>

        <a href="/assets/export/excel" class="btn btn-info" style="min-width: 180px;">
            Export Excel
        </a>

        @if(auth()->user()->isAdmin())
            <a href="/assets/history" class="btn btn-dark" style="min-width: 180px;">
                View History
            </a>
        @endif

    </div>

    <!-- FILTER -->
    <form method="GET" action="/dashboard" class="mb-3 d-flex gap-2">

        <input type="text" name="search" class="form-control" placeholder="Search assets...">

        <select name="department" class="form-control">
            <option value="">All Departments</option>
            <option value="ICT">ICT</option>
            <option value="Health">Health</option>
            <option value="Finance">Finance</option>
            <option value="Roads">Roads</option>
            <option value="Water">Water</option>
            <option value="Agriculture">Agriculture</option>
            <option value="Education">Education</option>
            <option value="Administration">Administration</option>
            <option value="Tourism">Tourism</option>
        </select>

        <button class="btn btn-secondary">Filter</button>

    </form>

    <!-- CARDS -->
    <div class="row">

        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalAssets ?? 0 }}</h3>
                    <p>Total Assets</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $activeAssets ?? 0 }}</h3>
                    <p>Active Assets</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $faultyAssets ?? 0 }}</h3>
                    <p>Faulty Assets</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalMaintenance ?? 0 }}</h3>
                    <p>Maintenance</p>
                </div>
            </div>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="row">

        <div class="col-md-6">
            <div class="card" style="height: 320px;">
                <div class="card-header">
                    <h3>Status Breakdown</h3>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="height: 320px;">
                <div class="card-header">
                    <h3>Department Breakdown</h3>
                </div>
                <div class="card-body">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card mt-3">
        <div class="card-header">
            <h3>Asset Records</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->category }}</td>
                            <td>{{ $asset->serial_number }}</td>
                            <td>{{ $asset->status }}</td>
                            <td>{{ $asset->assigned_to }}</td>
                            <td>{{ $asset->location }}</td>
                            <td>
                                <a href="/assets/{{ $asset->id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                                @if(auth()->user()->isAdmin())
                                <form method="POST" action="/assets/{{ $asset->id }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No assets found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@stop


{{-- ================= JS SECTION ================= --}}
@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // STATUS CHART
    const statusCanvas = document.getElementById('statusChart');

    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chartData->keys()) !!},
                datasets: [{
                    label: 'Assets by Status',
                    data: {!! json_encode($chartData->values()) !!},
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107',
                        '#0d6efd'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // DEPARTMENT CHART
    const departmentCanvas = document.getElementById('departmentChart');

    if (departmentCanvas) {
        new Chart(departmentCanvas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($departmentChart->keys()) !!},
                datasets: [{
                    label: 'Assets per Department',
                    data: {!! json_encode($departmentChart->values()) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                }
            }
        });
    }

});
</script>

@stop