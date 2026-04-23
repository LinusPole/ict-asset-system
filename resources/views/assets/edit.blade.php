<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset</title>

    <!-- Bootstrap -->
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

        <input type="text" name="name" class="form-control mb-2"
            value="{{ $asset->name }}" placeholder="Asset Name">

        <input type="text" name="category" class="form-control mb-2"
            value="{{ $asset->category }}" placeholder="Category">

        <input type="text" name="serial_number" class="form-control mb-2"
            value="{{ $asset->serial_number }}" placeholder="Serial Number">

        <select name="status" class="form-control mb-2">
            <option value="Active" {{ $asset->status === 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Faulty" {{ $asset->status === 'Faulty' ? 'selected' : '' }}>Faulty</option>
            <option value="In Repair" {{ $asset->status === 'In Repair' ? 'selected' : '' }}>In Repair</option>
            <option value="Retired" {{ $asset->status === 'Retired' ? 'selected' : '' }}>Retired</option>
        </select>

        <input type="text" name="assigned_to" class="form-control mb-2"
            value="{{ $asset->assigned_to }}" placeholder="Assigned To">

        <input type="text" name="location" class="form-control mb-2"
            value="{{ $asset->location }}" placeholder="Location">

        <button type="submit" class="btn btn-primary">Update Asset</button>

        <a href="/" class="btn btn-secondary">Cancel</a>

    </form>

</div>

</body>
</html>