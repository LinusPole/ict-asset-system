<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Edit Asset</h1>

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

    <form method="POST" action="/assets/{{ $asset->id }}">
        @csrf
        @method('PUT')

        <!-- Name -->
        <input type="text"
               name="name"
               class="form-control mb-2"
               value="{{ $asset->name }}"
               placeholder="Asset Name">

        <!-- CATEGORY (FIXED DROPDOWN ONLY) -->
        <select name="category" class="form-control mb-2" required>
            <option value="">-- Select ICT Equipment --</option>

            <option value="Laptop" {{ $asset->category == 'Laptop' ? 'selected' : '' }}>Laptop</option>
            <option value="Desktop" {{ $asset->category == 'Desktop' ? 'selected' : '' }}>Desktop</option>
            <option value="Printer" {{ $asset->category == 'Printer' ? 'selected' : '' }}>Printer</option>
            <option value="Server" {{ $asset->category == 'Server' ? 'selected' : '' }}>Server</option>
            <option value="Router" {{ $asset->category == 'Router' ? 'selected' : '' }}>Router</option>
            <option value="Switch" {{ $asset->category == 'Switch' ? 'selected' : '' }}>Switch</option>
            <option value="Scanner" {{ $asset->category == 'Scanner' ? 'selected' : '' }}>Scanner</option>
            <option value="UPS" {{ $asset->category == 'UPS' ? 'selected' : '' }}>UPS</option>
            <option value="Projector" {{ $asset->category == 'Projector' ? 'selected' : '' }}>Projector</option>
            <option value="Mobile Device" {{ $asset->category == 'Mobile Device' ? 'selected' : '' }}>Mobile Device</option>
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

        <!-- Serial Number -->
        <input type="text"
               name="serial_number"
               class="form-control mb-2"
               value="{{ $asset->serial_number }}"
               placeholder="Serial Number">

        <!-- Status -->
        <select name="status" class="form-control mb-2">
            <option value="Active" {{ $asset->status === 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Faulty" {{ $asset->status === 'Faulty' ? 'selected' : '' }}>Faulty</option>
            <option value="In Repair" {{ $asset->status === 'In Repair' ? 'selected' : '' }}>In Repair</option>
            <option value="Retired" {{ $asset->status === 'Retired' ? 'selected' : '' }}>Retired</option>
        </select>

        <!-- Assigned To -->
        <input type="text"
               name="assigned_to"
               class="form-control mb-2"
               value="{{ $asset->assigned_to }}"
               placeholder="Assigned To">

        <!-- Location -->
        <input type="text"
               name="location"
               class="form-control mb-2"
               value="{{ $asset->location }}"
               placeholder="Location">

        <button type="submit" class="btn btn-primary">
            Update Asset
        </button>

        <a href="/" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

</body>
</html>