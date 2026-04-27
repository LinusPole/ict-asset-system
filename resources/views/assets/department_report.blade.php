<!DOCTYPE html>
<html>
<head>
    <title>{{ $department }} ICT Assets Report</title>

    <style>
        body { font-family: Arial; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

    <h2>{{ $department }} Department - ICT Assets Report</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Serial Number</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Location</th>
            </tr>
        </thead>

        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category }}</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>{{ $asset->status }}</td>
                    <td>{{ $asset->assigned_to }}</td>
                    <td>{{ $asset->location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>