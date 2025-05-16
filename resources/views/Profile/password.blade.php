@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #3563E9;
        --accent: #4FBAEE;
        --background: #1C3139;
        --card-bg: rgba(255, 255, 255, 0.05);
        --text: #f0f0f0;
        --gradient: linear-gradient(135deg, #ffb347, #ffd447);
        --hover-gradient: linear-gradient(135deg, #c9a000, #d6bb00);
    }

    body {
        background: var(--background);
        font-family: 'Segoe UI', sans-serif;
        color: var(--text);
    }

    .form-container {
        max-width: 600px;
        margin: 3rem auto;
        background: var(--card-bg);
        border-radius: 18px;
        padding: 2.5rem 2rem;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .form-title {
        font-size: 1.5rem;
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
        box-shadow: 0 0 8px rgba(255, 209, 102, 0.3);
        background: rgba(255, 255, 255, 0.07);
        color: white;
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
        background: var(--hover-gradient);
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

<div class="form-container">
    <h2 class="form-title">🔒 Changer le mot de passe</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" name="current_password" required>
        </div>

        <div class="mb-4">
            <label for="new_password" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" name="new_password" required>
        </div>

        <div class="mb-4">
            <label for="new_password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" name="new_password_confirmation" required>
        </div>

        <div class="d-flex justify-content-between border-top pt-4 mt-4">
            <a href="{{ route('profile.show') }}" class="btn-outline-light">
                <i class="bi bi-x me-1"></i>Retour
            </a>
            <button type="submit" class="btn-gradient">
                <i class="bi bi-lock me-1"></i>Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
