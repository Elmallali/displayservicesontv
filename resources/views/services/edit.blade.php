@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Service</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Service Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $service->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
        </div>

        @if ($service->image)
            <div class="mb-3">
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" style="max-width: 300px; border-radius: 6px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Service</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Service Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $service->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
        </div>

        @if ($service->image)
            <div class="mb-3">
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" style="max-width: 300px; border-radius: 6px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
