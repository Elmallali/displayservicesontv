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

    .confirm-container {
        max-width: 550px;
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
        text-align: center;
    }

    .form-text {
        text-align: center;
        margin-bottom: 2rem;
        color: #ccc;
        font-size: 0.95rem;
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

    .btn-link {
        color: #aaa;
        font-size: 0.9rem;
    }

    .btn-link:hover {
        color: white;
        text-decoration: underline;
    }

    .invalid-feedback {
        color: #f99;
        font-size: 0.875rem;
    }
</style>

<div class="confirm-container">
    <h2 class="form-title">🔒 Confirmation du mot de passe</h2>
    <p class="form-text">
        Veuillez confirmer votre mot de passe avant de continuer.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">

            @error('password')
                <div class="invalid-feedback mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn-gradient">
                Confirmer
            </button>

            @if (Route::has('password.request'))
                <a class="btn-link" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
