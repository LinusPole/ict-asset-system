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

        <div class="form-group">
    <label>Category</label>

    <select name="category" class="form-control" required>
        <option value="">-- Select ICT Equipment --</option>
        <option value="Laptop">Laptop</option>
        <option value="Desktop">Desktop</option>
        <option value="Printer">Printer</option>
        <option value="Server">Server</option>
        <option value="Router">Router</option>
        <option value="Switch">Switch</option>
        <option value="Scanner">Scanner</option>
        <option value="UPS">UPS</option>
        <option value="Projector">Projector</option>
        <option value="Mobile Device">Mobile Device</option>
    </select>

    <select name="department" class="form-control mb-2" required>
    <option value="">-- Select Department --</option>

    <option value="ICT" {{ old('department', $asset->department ?? '') == 'ICT' ? 'selected' : '' }}>ICT</option>
    <option value="Health" {{ old('department', $asset->department ?? '') == 'Health' ? 'selected' : '' }}>Health</option>
    <option value="Finance" {{ old('department', $asset->department ?? '') == 'Finance' ? 'selected' : '' }}>Finance</option>
    <option value="Roads" {{ old('department', $asset->department ?? '') == 'Roads' ? 'selected' : '' }}>Roads</option>
    <option value="Water" {{ old('department', $asset->department ?? '') == 'Water' ? 'selected' : '' }}>Water</option>
    <option value="Agriculture" {{ old('department', $asset->department ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
    <option value="Education" {{ old('department', $asset->department ?? '') == 'Education' ? 'selected' : '' }}>Education</option>
    <option value="Administration" {{ old('department', $asset->department ?? '') == 'Administration' ? 'selected' : '' }}>Administration</option>
    <option value="Tourism" {{ old('department', $asset->department ?? '') == 'Tourism' ? 'selected' : '' }}>Tourism</option>
</select>
</div>

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