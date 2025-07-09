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

    .page-container {
        padding: 2rem 1rem;
        max-width: 800px;
        margin: auto;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--accent);
    }

    .card-modern {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        padding: 25px;
        margin-bottom: 2rem;
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
        text-decoration: none;
    }

    .btn-danger {
        border: 1px solid #e74c3c;
        background: transparent;
        color: #e74c3c;
    }

    .btn-danger:hover {
        background: #e74c3c;
        color: #fff;
    }

    .info-group {
        margin-bottom: 1.5rem;
    }

    .info-label {
        font-size: 0.9rem;
        color: var(--accent);
        margin-bottom: 0.3rem;
        font-weight: 600;
    }

    .info-value {
        font-size: 1.1rem;
        color: var(--text);
        padding: 10px 15px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .badge-active {
        background-color: rgba(46, 204, 113, 0.2);
        color: #2ecc71;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .badge-inactive {
        background-color: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .day-badge {
        text-transform: capitalize;
        background-color: rgba(51, 148, 205, 0.2);
        color: var(--accent);
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .time-badge {
        background-color: rgba(255, 255, 255, 0.1);
        color: var(--text);
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 2rem 0 1rem;
        color: var(--accent);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.5rem;
    }
    
    .eleve-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 1rem;
    }
    
    .eleve-badge {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
    }
    
    .eleve-badge i {
        margin-right: 5px;
        color: var(--accent);
    }
</style>

<div class="page-container">
    <h1 class="page-title">Détails de l'horaire</h1>
    
    <div class="card-modern">
        <div class="row">
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Formation</div>
                    <div class="info-value">
                        <strong>{{ $emploiDuTemp->formation->nom }}</strong><br>
                        <span class="badge-active">{{ $emploiDuTemp->formation->niveau_langue }}</span>
                        <small class="ms-2">{{ ucfirst($emploiDuTemp->formation->langue) }}</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Formateur</div>
                    <div class="info-value">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        {{ $emploiDuTemp->formation->formateur->nom }}
                        <small class="d-block mt-1">{{ $emploiDuTemp->formation->formateur->specialite }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Salle</div>
                    <div class="info-value">
                        <i class="fas fa-door-open me-2"></i>
                        {{ $emploiDuTemp->salle->nom }}
                        <small class="d-block mt-1">Capacité: {{ $emploiDuTemp->salle->capacite }} personnes</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Jour et Horaire</div>
                    <div class="info-value">
                        <span class="day-badge">{{ $emploiDuTemp->jour }}</span>
                        <span class="time-badge ms-2">
                            {{ \Carbon\Carbon::parse($emploiDuTemp->heure_debut)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($emploiDuTemp->heure_fin)->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Période</div>
                    <div class="info-value">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Du {{ \Carbon\Carbon::parse($emploiDuTemp->date_debut)->format('d/m/Y') }}
                        @if($emploiDuTemp->date_fin)
                            au {{ \Carbon\Carbon::parse($emploiDuTemp->date_fin)->format('d/m/Y') }}
                        @else
                            <span class="text-muted">(sans date de fin)</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Statut</div>
                    <div class="info-value">
                        @if($emploiDuTemp->est_actif)
                            <span class="badge-active">Actif</span>
                        @else
                            <span class="badge-inactive">Inactif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section-title">Élèves inscrits à cette formation</div>
        
        @if($emploiDuTemp->formation->elevesActifs()->count() > 0)
            <div class="eleve-list">
                @foreach($emploiDuTemp->formation->elevesActifs as $eleve)
                    <div class="eleve-badge">
                        <i class="fas fa-user-graduate"></i>
                        {{ $eleve->nom }} {{ $eleve->prenom }}
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aucun élève n'est actuellement inscrit à cette formation.</p>
        @endif
        
        <div class="d-flex justify-content-between mt-4">
            <div>
                <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
                    <i class="fas fa-list me-1"></i> Liste des horaires
                </a>
                <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
                    <i class="fas fa-calendar-week me-1"></i> Vue par jour
                </a>
                @include('components.back-button', ['url' => route('home'), 'text' => 'Retour à l\'accueil'])
            </div>
            
            @if(Auth::user()->role === 'admin')
                <div>
                    <a href="{{ route('emploi-du-temps.edit', $emploiDuTemp->id) }}" class="btn-modern">
                        <i class="fas fa-edit me-1"></i> Modifier
                    </a>
                    
                    <a href="#" class="btn-modern btn-danger" 
                       onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?')) document.getElementById('delete-emploi').submit();">
                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                    </a>
                    
                    <form id="delete-emploi" action="{{ route('emploi-du-temps.destroy', $emploiDuTemp->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
