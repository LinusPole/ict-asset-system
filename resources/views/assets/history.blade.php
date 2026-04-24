<!DOCTYPE html>
<html>
<head>
    <title>Asset History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Asset History Log</h2>

        <a href="/dashboard" class="btn btn-primary">
            Back to Dashboard
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Asset Name</th>
                <th>Action</th>
                <th>Performed By</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td>{{ $history->asset->name ?? 'Deleted Asset' }}</td>
                    <td>{{ $history->action }}</td>
                    <td>{{ $history->performed_by }}</td>
                    <td>{{ $history->description }}</td>
                    <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No history records found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>