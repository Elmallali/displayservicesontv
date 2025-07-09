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
        max-width: 1200px;
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

    .formation-info {
        margin-bottom: 2rem;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .formation-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .formation-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--accent);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .formation-title h3 {
        margin: 0 0 5px 0;
        font-size: 1.5rem;
    }

    .formation-badge {
        display: inline-block;
        background-color: rgba(51, 148, 205, 0.2);
        color: var(--accent);
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-right: 10px;
    }

    .formation-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .formation-detail {
        flex: 1 0 200px;
        background-color: rgba(255, 255, 255, 0.05);
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .detail-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 1rem;
        color: var(--text);
    }

    .day-tabs {
        display: flex;
        overflow-x: auto;
        margin-bottom: 1.5rem;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .day-tab {
        padding: 10px 20px;
        margin-right: 10px;
        border-radius: 8px 8px 0 0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: capitalize;
        color: var(--text);
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: none;
    }

    .day-tab.active {
        background-color: var(--card-bg);
        color: var(--accent);
        border-bottom: 2px solid var(--accent);
    }

    .day-content {
        display: none;
    }

    .day-content.active {
        display: block;
    }

    .schedule-card {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .schedule-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .schedule-time {
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 8px;
        font-size: 1.1rem;
    }

    .schedule-details {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .empty-day {
        text-align: center;
        padding: 2rem 1rem;
    }

    .empty-icon {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.2);
        margin-bottom: 1rem;
    }

    .empty-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .students-section {
        margin-top: 2rem;
    }

    .students-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .students-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--accent);
    }

    .student-count {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .student-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .student-badge {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .student-badge:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .student-badge i {
        margin-right: 5px;
        color: var(--accent);
    }
</style>

<div class="page-container">
    <h1 class="page-title">Emploi du Temps de la Formation</h1>
    
    <div class="formation-info">
        <div class="formation-header">
            <div class="formation-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="formation-title">
                <h3>{{ $formation->nom }}</h3>
                <div>
                    <span class="formation-badge">{{ $formation->niveau_langue }}</span>
                    <span>{{ ucfirst($formation->langue) }}</span>
                </div>
            </div>
        </div>
        
        <div class="formation-details">
            <div class="formation-detail">
                <div class="detail-label">Formateur</div>
                <div class="detail-value">
                    <i class="fas fa-chalkboard-teacher me-1"></i> {{ $formation->formateur->nom }}
                </div>
            </div>
            
            <div class="formation-detail">
                <div class="detail-label">Prix mensuel</div>
                <div class="detail-value">
                    <i class="fas fa-money-bill-wave me-1"></i> {{ $formation->prix_mensuel }} DH
                </div>
            </div>
            
            <div class="formation-detail">
                <div class="detail-label">Durée</div>
                <div class="detail-value">
                    <i class="fas fa-calendar-alt me-1"></i> {{ $formation->duree_mois }} mois
                </div>
            </div>
            
            <div class="formation-detail">
                <div class="detail-label">Places</div>
                <div class="detail-value">
                    <i class="fas fa-users me-1"></i> {{ $formation->places_disponibles }}/{{ $formation->places_maximum }} disponibles
                </div>
            </div>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @php
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $emploiParJour = [];
        
        foreach ($jours as $jour) {
            $emploiParJour[$jour] = $emploiDuTemps->filter(function($item) use ($jour) {
                return $item->jour === $jour;
            });
        }
    @endphp
    
    <div class="card-modern">
        <h3 class="mb-3">Horaires des cours</h3>
        
        <div class="day-tabs">
            @foreach($jours as $jour)
                <div class="day-tab {{ $loop->first ? 'active' : '' }}" data-day="{{ $jour }}">
                    {{ ucfirst($jour) }}
                </div>
            @endforeach
        </div>
        
        @foreach($jours as $jour)
            <div class="day-content {{ $loop->first ? 'active' : '' }}" id="day-{{ $jour }}">
                <h4 class="mb-3 text-capitalize">{{ ucfirst($jour) }}</h4>
                
                @if(isset($emploiParJour[$jour]) && count($emploiParJour[$jour]) > 0)
                    <div class="row">
                        @foreach($emploiParJour[$jour]->sortBy('heure_debut') as $emploi)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="schedule-card">
                                    <div class="schedule-time">
                                        {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}
                                    </div>
                                    <div class="schedule-details">
                                        <div>
                                            <i class="fas fa-door-open me-1"></i> Salle: {{ $emploi->salle->nom }}
                                        </div>
                                        
                                        @if($emploi->date_fin)
                                            <div>
                                                <i class="fas fa-calendar-day me-1"></i> Jusqu'au {{ \Carbon\Carbon::parse($emploi->date_fin)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <div class="mt-3 d-flex justify-content-end">
                                            <a href="{{ route('emploi-du-temps.edit', $emploi->id) }}" class="btn-modern btn-sm">
                                                <i class="fas fa-edit me-1"></i> Modifier
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-day">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <p class="empty-text">Aucun cours programmé pour {{ $jour }}.</p>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('emploi-du-temps.create') }}" class="btn-modern">
                                <i class="fas fa-plus-circle me-1"></i> Ajouter un horaire
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
        
        <div class="students-section">
            <div class="students-header">
                <div class="students-title">Élèves inscrits</div>
                <div class="student-count">{{ $formation->elevesActifs()->count() }} élèves</div>
            </div>
            
            @if($formation->elevesActifs()->count() > 0)
                <div class="student-list">
                    @foreach($formation->elevesActifs as $eleve)
                        <div class="student-badge">
                            <i class="fas fa-user-graduate"></i>
                            {{ $eleve->nom }} {{ $eleve->prenom }}
                            
                            @if($eleve->aPayePourMoisCourant($formation))
                                <i class="fas fa-check-circle ms-1 text-success"></i>
                            @else
                                <i class="fas fa-exclamation-circle ms-1 text-danger"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Aucun élève n'est actuellement inscrit à cette formation.</p>
            @endif
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('formations.show', $formation->id) }}" class="btn-modern">
            <i class="fas fa-info-circle me-1"></i> Détails de la formation
        </a>
        <a href="{{ route('formations.eleves', $formation->id) }}" class="btn-modern">
            <i class="fas fa-users me-1"></i> Gestion des élèves
        </a>
        <a href="{{ route('paiements.formation', $formation->id) }}" class="btn-modern">
            <i class="fas fa-money-bill-wave me-1"></i> Paiements
        </a>
        <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
            <i class="fas fa-th me-1"></i> Vue générale
        </a>
        <a href="{{ route('home') }}" class="btn-modern">
            <i class="fas fa-home me-1"></i> Accueil
        </a>
    </div>
    
    <div class="mt-3">
        @include('components.back-button', ['url' => route('formations.index'), 'text' => 'Retour à la liste des formations'])
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const dayTabs = document.querySelectorAll('.day-tab');
    const dayContents = document.querySelectorAll('.day-content');
    
    dayTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const day = this.getAttribute('data-day');
            
            
            dayTabs.forEach(t => t.classList.remove('active'));
            dayContents.forEach(c => c.classList.remove('active'));
            
            
            this.classList.add('active');
            document.getElementById('day-' + day).classList.add('active');
        });
    });
});
</script>
@endsection
