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
    
    .form-select option {
        background-color: var(--background);
        color: var(--text);
    }

    .form-check-input {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-check-input:checked {
        background-color: var(--accent);
        border-color: var(--accent);
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
        <h2 class="form-title">Ajouter une nouvelle salle</h2>
        
        <form action="{{ route('salles.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la salle <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="etage" class="form-label">Étage</label>
                <input type="text" class="form-control @error('etage') is-invalid @enderror" id="etage" name="etage" value="{{ old('etage') }}">
                @error('etage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="capacite" class="form-label">Capacité (nombre de personnes) <span class="text-danger">*</span></label>
                <input type="number" min="1" class="form-control @error('capacite') is-invalid @enderror" id="capacite" name="capacite" value="{{ old('capacite', 15) }}" required>
                @error('capacite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="est_disponible" name="est_disponible" value="1" {{ old('est_disponible', '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="est_disponible">Salle disponible</label>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('salles.index') }}" class="btn-modern">
                    <i class="fas fa-arrow-left me-1"></i>Annuler
                </a>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check-lg me-1"></i>Créer la salle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
