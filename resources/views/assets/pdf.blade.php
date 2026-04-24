<!DOCTYPE html>
<html>
<head>
    <title>ICT Asset Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>ICT Asset Management Report</h2>

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