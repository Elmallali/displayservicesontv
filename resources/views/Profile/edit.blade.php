@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #3563E9;
        --accent: #4FBAEE;
        --background: #1C3139;
        --card-bg: rgba(255, 255, 255, 0.05);
        --text: #f0f0f0;
        --gradient: linear-gradient(135deg, #3394cd, #82CEF9);
    }

    body {
        background: var(--background);
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 2.5rem 2rem;
        background: var(--card-bg);
        border-radius: 18px;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .profile-title {
        font-size: 1.6rem;
        font-weight: 700;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text);
        padding: 12px;
        border-radius: 8px;
        transition: border 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border: 1px solid var(--accent);
        box-shadow: 0 0 8px rgba(79, 186, 238, 0.3);
        background: rgba(255, 255, 255, 0.07);
    }

    .btn-gradient {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .btn-gradient:hover {
        background: #2a4b57;
    }

    .btn-outline-light {
        border: 1px solid #aaa;
        color: #ccc;
        padding: 10px 18px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.05);
    }

    .alert-success {
        background: rgba(25, 135, 84, 0.1);
        color: #89f6c2;
        border-left: 4px solid #4ae1a0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
</style>

<div class="profile-container">
    <h2 class="profile-title">✏️ Modifier mes informations</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        {{-- Nom --}}
        <div class="mb-4">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="d-flex justify-content-between border-top pt-4 mt-4">
            <a href="{{ route('profile.show') }}" class="btn-outline-light">
                <i class="bi bi-x me-1"></i>Retour
            </a>
            <button type="submit" class="btn-gradient">
                <i class="bi bi-save me-1"></i>Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
