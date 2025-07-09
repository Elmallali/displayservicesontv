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
    
    .alert-info {
        background-color: rgba(51, 148, 205, 0.18);
        border: 1px solid rgba(51, 148, 205, 0.3);
        color: #f0f0f0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="modern-container">
    <div class="form-card">
        <h2 class="form-title">Ajouter un nouvel horaire</h2>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Avant d'ajouter un horaire, assurez-vous que la salle et le formateur sont disponibles à ce moment-là.
        </div>
        
        <form action="{{ route('emploi-du-temps.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="formation_id" class="form-label">Formation <span class="text-danger">*</span></label>
                <select class="form-select @error('formation_id') is-invalid @enderror" id="formation_id" name="formation_id" required>
                    <option value="" disabled selected>Sélectionnez une formation</option>
                    @foreach ($formations as $formation)
                        <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                            {{ $formation->nom }} ({{ $formation->niveau_langue }} - {{ ucfirst($formation->langue) }}) - Formateur: {{ $formation->formateur->nom }}
                        </option>
                    @endforeach
                </select>
                @error('formation_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="salle_id" class="form-label">Salle <span class="text-danger">*</span></label>
                <select class="form-select @error('salle_id') is-invalid @enderror" id="salle_id" name="salle_id" required>
                    <option value="" disabled selected>Sélectionnez une salle</option>
                    @foreach ($salles as $salle)
                        <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                            {{ $salle->nom }} (Capacité: {{ $salle->capacite }} personnes)
                        </option>
                    @endforeach
                </select>
                @error('salle_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="jour" class="form-label">Jour <span class="text-danger">*</span></label>
                <select class="form-select @error('jour') is-invalid @enderror" id="jour" name="jour" required>
                    <option value="" disabled selected>Sélectionnez un jour</option>
                    @foreach ($jours as $jour)
                        <option value="{{ $jour }}" {{ old('jour') == $jour ? 'selected' : '' }}>
                            {{ ucfirst($jour) }}
                        </option>
                    @endforeach
                </select>
                @error('jour')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="heure_debut" class="form-label">Heure de début <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('heure_debut') is-invalid @enderror" id="heure_debut" name="heure_debut" value="{{ old('heure_debut') }}" required>
                    @error('heure_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="heure_fin" class="form-label">Heure de fin <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('heure_fin') is-invalid @enderror" id="heure_fin" name="heure_fin" value="{{ old('heure_fin') }}" required>
                    @error('heure_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" name="date_debut" value="{{ old('date_debut', date('Y-m-d')) }}" required>
                    @error('date_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" name="date_fin" value="{{ old('date_fin') }}">
                    <small class="text-muted">Laissez vide pour une durée indéterminée</small>
                    @error('date_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="est_actif" name="est_actif" value="1" {{ old('est_actif', '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="est_actif">Horaire actif</label>
            </div>
            
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
                        <i class="fas fa-arrow-left me-1"></i>Annuler
                    </a>
                    @include('components.back-button', ['url' => route('home'), 'text' => 'Retour à l\'accueil'])
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus-circle me-1"></i>Créer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const salleSelect = document.getElementById('salle_id');
    const jourSelect = document.getElementById('jour');
    const heureDebutInput = document.getElementById('heure_debut');
    const heureFinInput = document.getElementById('heure_fin');
    
    const checkAvailability = function() {
        const salleId = salleSelect.value;
        const jour = jourSelect.value;
        const heureDebut = heureDebutInput.value;
        const heureFin = heureFinInput.value;
        
        
        if (salleId && jour && heureDebut && heureFin) {
            
            
            console.log('Checking availability for:', {
                salleId,
                jour,
                heureDebut,
                heureFin
            });
        }
    };
    
    salleSelect.addEventListener('change', checkAvailability);
    jourSelect.addEventListener('change', checkAvailability);
    heureDebutInput.addEventListener('change', checkAvailability);
    heureFinInput.addEventListener('change', checkAvailability);
});
</script>
@endsection
