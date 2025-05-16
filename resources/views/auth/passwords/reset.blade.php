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
        --hover-gradient: linear-gradient(135deg, #1c3139, #2a4b57);
    }

    body {
        background: var(--background);
        font-family: 'Segoe UI', sans-serif;
        color: var(--text);
    }

    .reset-token-container {
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
        margin-bottom: 2rem;
        text-align: center;
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
        background: var(--hover-gradient);
    }

    .invalid-feedback {
        color: #f99;
        font-size: 0.875rem;
    }
</style>

<div class="reset-token-container">
    <h2 class="form-title">🔁 Réinitialiser le mot de passe</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- Token hidden --}}
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ $email ?? old('email') }}" required autofocus>

            @error('email')
                <div class="invalid-feedback mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required>

            @error('password')
                <div class="invalid-feedback mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm --}}
        <div class="mb-4">
            <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
            <input id="password-confirm" type="password"
                   class="form-control"
                   name="password_confirmation" required>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn-gradient">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>
</div>
@endsection
