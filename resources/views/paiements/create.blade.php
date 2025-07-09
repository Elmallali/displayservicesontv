@extends('layouts.app')

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

    .form-container {
        max-width: 800px;
        margin: 3rem auto;
        padding: 2rem;
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 25px;
        color: var(--accent);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 16px;
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: var(--accent);
        color: var(--text);
        box-shadow: 0 0 0 0.25rem rgba(79, 186, 238, 0.25);
    }

    .form-label {
        color: #ddd;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-select {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 16px;
    }

    .form-check-input {
        width: auto;
        margin-right: 10px;
    }

    .form-check-label {
        font-weight: normal;
        display: inline;
    }

    .btn-modern {
        border: 1px solid var(--accent);
        background: transparent;
        color: var(--accent);
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 1rem;
        transition: background 0.3s, color 0.3s;
        margin-right: 10px;
        text-decoration: none;
    }

    .btn-modern:hover {
        background: var(--accent);
        color: #fff;
    }

    .btn-submit {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.4s ease;
    }

    .btn-submit:hover {
        background: var(--hover-gradient);
    }

    .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.85rem;
        display: block;
        margin-top: -10px;
        margin-bottom: 10px;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Ajouter un Paiement</h2>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="eleve_id" class="form-label">Élève <span class="text-danger">*</span></label>
            <select name="eleve_id" id="eleve_id" class="form-select @error('eleve_id') is-invalid @enderror" required>
                <option value="" disabled selected>Sélectionnez un élève</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                        {{ $eleve->nom }} {{ $eleve->prenom }} - {{ $eleve->langue_suivie }}
                    </option>
                @endforeach
            </select>
            @error('eleve_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="formation_id" class="form-label">Formation <span class="text-danger">*</span></label>
            <select name="formation_id" id="formation_id" class="form-select @error('formation_id') is-invalid @enderror" required>
                <option value="" disabled selected>Sélectionnez une formation</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                        {{ $formation->nom }} ({{ $formation->niveau }}) - {{ $formation->prix_mensuel }} DH/mois
                    </option>
                @endforeach
            </select>
            @error('formation_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mois" class="form-label">Mois <span class="text-danger">*</span></label>
            <input type="text" name="mois" id="mois" class="form-control @error('mois') is-invalid @enderror" placeholder="Ex: Mai 2025" value="{{ old('mois', date('F Y')) }}" required>
            @error('mois')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="montant" class="form-label">Montant (DH) <span class="text-danger">*</span></label>
            <input type="number" name="montant" id="montant" class="form-control @error('montant') is-invalid @enderror" step="0.01" value="{{ old('montant') }}" required>
            @error('montant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="date_paiement" class="form-label">Date du paiement <span class="text-danger">*</span></label>
            <input type="date" name="date_paiement" id="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
            @error('date_paiement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="methode" class="form-label">Méthode de paiement</label>
            <input type="text" name="methode" id="methode" class="form-control @error('methode') is-invalid @enderror" placeholder="Ex: cash, virement, chèque" value="{{ old('methode') }}">
            @error('methode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="est_confirme" id="est_confirme" {{ old('est_confirme') ? 'checked' : '' }}>
                <label class="form-check-label" for="est_confirme">
                    Confirmer ce paiement immédiatement
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label for="commentaire" class="form-label">Commentaire</label>
            <textarea name="commentaire" id="commentaire" class="form-control @error('commentaire') is-invalid @enderror" rows="3" placeholder="Commentaire optionnel sur ce paiement">{{ old('commentaire') }}</textarea>
            @error('commentaire')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('paiements.index') }}" class="btn-modern">
                <i class="bi bi-arrow-left me-1"></i>Annuler
            </a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-check-lg me-1"></i>Enregistrer le paiement
            </button>
        </div>
    </form>
</div>
@endsection
