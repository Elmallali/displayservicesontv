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
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .reset-container {
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

    .alert-success {
        background: rgba(25, 135, 84, 0.1);
        color: #89f6c2;
        border-left: 4px solid #4ae1a0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .invalid-feedback {
        color: #f99;
        font-size: 0.875rem;
    }
</style>

<div class="reset-container">
    <h2 class="form-title">🔁 Réinitialisation du mot de passe</h2>

    @if (session('status'))
        <div class="alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
                <div class="invalid-feedback mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn-gradient">
                Envoyer le lien de réinitialisation
            </button>
        </div>
    </form>
</div>
@endsection
