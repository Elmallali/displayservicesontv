@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<style>
    :root {
        --primary: #3563E9;
        --secondary: #121A2D;
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

    .modern-container {
        padding: 3rem 1rem;
        max-width: 1200px;
        margin: auto;
    }

    .service-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.4);
    }

    .service-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .service-body {
        padding: 20px;
    }

    .service-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .service-desc {
        font-size: 1rem;
        color: #ddd;
        margin-bottom: 15px;
    }

    .btn-modern {
        border: 1px solid var(--accent);
        background: transparent;
        color: var(--accent);
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: background 0.3s, color 0.3s;
    }

    .btn-modern:hover {
        background: var(--accent);
        color: #fff;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .btn-add {
        background: var(--gradient);
        color: white;
        padding: 10px 18px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        transition: background 0.4s ease;
        text-decoration: none;
    }

    .btn-add:hover {
        background: var(--hover-gradient);
    }

</style>

<div class="modern-container">

    <div class="header-actions">
        <h2>Manage Services</h2>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('services.create') }}" class="btn-add">+ Add New Service</a>
        @endif
    </div>
    <div class="header-actions">
        <a href="{{ route('home') }}" class="text-decoration-none text-secondary mt-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i>Retour
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($services->isEmpty())
        <p>No services found.</p>
    @else
        <div class="row">
            @foreach ($services as $service)
                <div class="col-md-6 mb-4">
                    <div class="service-card">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="service-img">
                        @endif
                        <div class="service-body">
                            <div class="service-title">{{ $service->title }}</div>
                            <div class="service-desc">{{ $service->description }}</div>

                            @if(Auth::user()->role === 'admin')
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('services.edit', $service->id) }}" class="btn-modern">Edit</a>

                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-modern">Delete</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
