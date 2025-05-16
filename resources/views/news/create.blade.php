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

    .form-container {
        max-width: 750px;
        margin: 3rem auto;
        background: var(--card-bg);
        border-radius: 18px;
        padding: 2.5rem 2rem;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .form-title {
        font-size: 1.7rem;
        font-weight: 700;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
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
        color: white;
    }

    .input-group-text {
        background: rgba(255,255,255,0.08);
        color: #ccc;
        border: none;
        border-radius: 0 8px 8px 0;
    }

    .form-check-input {
        width: 2.3em;
        height: 1.2em;
        background-color: rgba(255,255,255,0.1);
        border: none;
    }

    .form-check-input:checked {
        background-color: var(--accent);
        box-shadow: 0 0 0 0.2rem rgba(79, 186, 238, 0.25);
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

    .alert {
        background: rgba(25, 135, 84, 0.1);
        color: #89f6c2;
        border-left: 4px solid #4ae1a0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: rgba(255, 0, 0, 0.1);
        color: #f99;
        border-left: 4px solid #ff6b6b;
    }
</style>

<div class="form-container">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="form-title">➕ Ajouter une nouveauté</h2>
            <a href="{{ url()->previous() }}" class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-triangle me-2"></i>Erreurs :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('news.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="texte" class="form-label">Texte de la nouveauté</label>
            <input type="text" name="texte" id="texte"
                   class="form-control @error('texte') is-invalid @enderror"
                   value="{{ old('texte') }}"
                   placeholder="Saisissez le texte à afficher" required>
            @error('texte')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="duration" class="form-label">Durée d'affichage</label>
            <div class="input-group">
                <input type="number" name="duration" id="duration"
                       class="form-control @error('duration') is-invalid @enderror"
                       value="{{ old('duration', 30) }}"
                       placeholder="Durée" min="1">
                <span class="input-group-text">secondes</span>
            </div>
            <small class="text-secondary">Temps d'affichage du bandeau de nouveauté</small>
            @error('duration')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch"
                   name="active" id="active" {{ old('active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">
                <span class="fw-medium">Afficher immédiatement</span><br>
                <small class="text-secondary">La nouveauté sera visible dès l'enregistrement</small>
            </label>
        </div>

        <div class="d-flex justify-content-between border-top pt-4 mt-4">
            <a href="{{ route('news.index') }}" class="btn-outline-light">
                <i class="bi bi-x me-1"></i>Annuler
            </a>
            <button type="submit" class="btn-gradient">
                <i class="bi bi-plus-circle me-1"></i>Ajouter
            </button>
        </div>
    </form>
</div>
@endsection
