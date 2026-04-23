<!DOCTYPE html>
<html>
<head>
    <title>Add Asset</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Add New Asset</h1>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/assets">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Asset Name">

        <input type="text" name="category" class="form-control mb-2" placeholder="Category">

        <input type="text" name="serial_number" class="form-control mb-2" placeholder="Serial Number">

        <select name="status" class="form-control mb-2">
            <option value="Active">Active</option>
            <option value="Faulty">Faulty</option>
            <option value="In Repair">In Repair</option>
            <option value="Retired">Retired</option>
        </select>

        <input type="text" name="assigned_to" class="form-control mb-2" placeholder="Assigned To">

        <input type="text" name="location" class="form-control mb-2" placeholder="Location">

        <button type="submit" class="btn btn-success">Save Asset</button>
    </form>

</div>

</body>
</html>