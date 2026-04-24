<!DOCTYPE html>
<html>
<head>
    <title>ICT Assets</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Welcome, {{ auth()->user()->name }}</h4>

        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <h1 class="mb-4">ICT Asset Management System</h1>

    <!-- Search -->
    <form method="GET" action="/" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search assets...">
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>

    <!-- Add Button -->
    <a href="/assets/create" class="btn btn-primary mb-4">+ Add Asset</a>
    <a href="/assets/export/pdf" class="btn btn-success mb-4">
    Export PDF Report
    </a>
    <a href="/assets/export/excel" class="btn btn-info mb-4">
    Export Excel Report
    </a>
    <a href="/assets/history" class="btn btn-dark mb-4">
    View Asset History
    </a>

    <!-- DASHBOARD CARDS -->
    <div class="row mb-4 mt-3">

        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Assets</h5>
                    <h2 class="mb-0">{{ $totalAssets ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Active Assets</h5>
                    <h2 class="mb-0">{{ $activeAssets ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5>Faulty Assets</h5>
                    <h2 class="mb-0">{{ $faultyAssets ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Assets by Status</h5>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Serial Number</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Location</th>
                <th width="150">Actions</th>
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

                    <!-- Edit -->
                    <a href="/assets/{{ $asset->id }}/edit" class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <!-- Delete -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <form action="/assets/{{ $asset->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this asset?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endauth

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

<!-- ✅ CHART SCRIPT (FIXED: runs after page loads) -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('statusChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                label: 'Assets',
                data: {!! json_encode($chartData->values()) !!},
                backgroundColor: [
                    '#28a745',
                    '#dc3545',
                    '#ffc107',
                    '#0d6efd'
                ],
                borderWidth: 1
            }]
        }
    });

});
</script>

</body>
</html>