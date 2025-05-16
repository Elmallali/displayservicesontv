@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #3563E9;
        --accent: #4FBAEE;
        --background: #1C3139;
        --card-bg: rgba(51, 148, 205, 0.18);
        --text: #f0f0f0;
        --gradient: linear-gradient(135deg, #3394cd, #82CEF9);
        --hover-gradient: linear-gradient(135deg, #1c3139, #2a4b57);
    }

    body {
        background: var(--background);
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .edit-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 2rem;
        background: var(--card-bg);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .edit-container h2 {
        text-align: center;
        margin-bottom: 2rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 2rem;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
        color: var(--text);
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text);
        padding: 10px 12px;
        border-radius: 6px;
        width: 100%;
        transition: border 0.3s;
    }

    .form-control:focus {
        outline: none;
        border: 1px solid var(--accent);
        box-shadow: 0 0 5px var(--accent);
        background: rgba(255, 255, 255, 0.1);
    }

    textarea.form-control {
        resize: vertical;
    }

    .btn-gradient {
        background: var(--gradient);
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 8px;
        transition: background 0.4s ease;
    }

    .btn-gradient:hover {
        background: var(--hover-gradient);
    }

    .btn-secondary {
        background: transparent;
        border: 1px solid #ccc;
        color: #ccc;
        padding: 10px 16px;
        margin-left: 10px;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.08);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .alert {
        background: rgba(255, 0, 0, 0.1);
        border-left: 5px solid red;
        color: #f99;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

</style>

<div class="edit-container">
    <h2>✏️ Edit Service</h2>
    <a href="{{ route('services.index') }}" class="text-decoration-none text-secondary mt-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>

    @if ($errors->any())
        <div class="alert">
            <strong>There were some errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Service Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $service->title) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $service->description) }}</textarea>
        </div>

        @if ($service->image)
            <div class="mb-3">
                <label class="form-label">Current Image:</label><br>
                <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" style="max-width: 300px; border-radius: 6px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-gradient">Update</button>
            <a href="{{ route('services.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
