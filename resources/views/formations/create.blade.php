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

    .modern-container {
        padding: 3rem 1rem;
        max-width: 800px;
        margin: auto;
    }

    .form-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        padding: 30px;
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
    }

    .form-select {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
        border-radius: 8px;
        padding: 12px 15px;
    }

    .form-select:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: var(--accent);
        color: var(--text);
        box-shadow: 0 0 0 0.25rem rgba(79, 186, 238, 0.25);
    }
    
    /* Fix for dropdown options */
    .form-select option {
        background-color: var(--background);
        color: var(--text);
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
    }
</style>

<div class="modern-container">
    <div class="form-card">
        <h2 class="form-title">Créer une nouvelle formation</h2>
        
        <form action="{{ route('formations.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la formation <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="niveau_langue" class="form-label">Niveau de langue <span class="text-danger">*</span></label>
                    <select class="form-select @error('niveau_langue') is-invalid @enderror" id="niveau_langue" name="niveau_langue" required>
                        <option value="" disabled selected>Sélectionnez un niveau</option>
                        @foreach ($niveauxLangue as $code => $niveau)
                            <option value="{{ $code }}" {{ old('niveau_langue') == $code ? 'selected' : '' }}>{{ $code }} - {{ $niveau }}</option>
                        @endforeach
                    </select>
                    @error('niveau_langue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="langue" class="form-label">Langue <span class="text-danger">*</span></label>
                    <select class="form-select @error('langue') is-invalid @enderror" id="langue" name="langue" required>
                        <option value="" disabled selected>Sélectionnez une langue</option>
                        @foreach ($langues as $langue)
                            <option value="{{ $langue }}" {{ old('langue') == $langue ? 'selected' : '' }}>{{ ucfirst($langue) }}</option>
                        @endforeach
                    </select>
                    @error('langue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="prix_mensuel" class="form-label">Prix mensuel (DH) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control @error('prix_mensuel') is-invalid @enderror" id="prix_mensuel" name="prix_mensuel" value="{{ old('prix_mensuel') }}" required>
                    @error('prix_mensuel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="duree_mois" class="form-label">Durée (mois) <span class="text-danger">*</span></label>
                    <input type="number" min="1" class="form-control @error('duree_mois') is-invalid @enderror" id="duree_mois" name="duree_mois" value="{{ old('duree_mois', 1) }}" required>
                    @error('duree_mois')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="places_maximum" class="form-label">Places maximum <span class="text-danger">*</span></label>
                    <input type="number" min="1" class="form-control @error('places_maximum') is-invalid @enderror" id="places_maximum" name="places_maximum" value="{{ old('places_maximum', 15) }}" required>
                    @error('places_maximum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="formateur_id" class="form-label">Formateur <span class="text-danger">*</span></label>
                <select class="form-select @error('formateur_id') is-invalid @enderror" id="formateur_id" name="formateur_id" required>
                    <option value="" disabled selected>Sélectionnez un formateur</option>
                    @foreach ($formateurs as $formateur)
                        <option value="{{ $formateur->id }}" {{ old('formateur_id') == $formateur->id ? 'selected' : '' }}>
                            {{ $formateur->nom }} ({{ $formateur->specialite }})
                        </option>
                    @endforeach
                </select>
                @error('formateur_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('formations.index') }}" class="btn-modern">
                    <i class="bi bi-arrow-left me-1"></i>Annuler
                </a>
                
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg me-1"></i>Créer la formation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
