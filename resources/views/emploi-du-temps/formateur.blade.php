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

    .formateur-info {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding: 15px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .formateur-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--accent);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .formateur-details h3 {
        margin: 0 0 5px 0;
        font-size: 1.5rem;
    }

    .formateur-details p {
        margin: 0;
        color: rgba(255, 255, 255, 0.7);
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

    .schedule-formation {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .schedule-details {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .schedule-badge {
        background-color: rgba(51, 148, 205, 0.2);
        color: var(--accent);
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .empty-day {
        text-align: center;
        padding: 3rem 1rem;
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
</style>

<div class="page-container">
    <h1 class="page-title">Emploi du Temps du Formateur</h1>
    
    <div class="formateur-info">
        <div class="formateur-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="formateur-details">
            <h3>{{ $formateur->nom }}</h3>
            <p><i class="fas fa-graduation-cap me-2"></i>{{ $formateur->specialite }}</p>
            <p><i class="fas fa-phone me-2"></i>{{ $formateur->telephone }}</p>
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
    
    <div class="day-tabs">
        @foreach($jours as $jour)
            <div class="day-tab {{ $loop->first ? 'active' : '' }}" data-day="{{ $jour }}">
                {{ ucfirst($jour) }}
            </div>
        @endforeach
    </div>
    
    <div class="card-modern">
        @foreach($jours as $jour)
            <div class="day-content {{ $loop->first ? 'active' : '' }}" id="day-{{ $jour }}">
                <h3 class="mb-4 text-capitalize">{{ ucfirst($jour) }}</h3>
                
                @if(isset($emploiParJour[$jour]) && count($emploiParJour[$jour]) > 0)
                    <div class="row">
                        @foreach($emploiParJour[$jour]->sortBy('heure_debut') as $emploi)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="schedule-card">
                                    <div class="schedule-time">
                                        {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}
                                    </div>
                                    <div class="schedule-formation">
                                        {{ $emploi->formation->nom }}
                                    </div>
                                    <div>
                                        <span class="schedule-badge">{{ $emploi->formation->niveau_langue }}</span>
                                        <span class="ms-2">{{ ucfirst($emploi->formation->langue) }}</span>
                                    </div>
                                    <div class="schedule-details">
                                        <div>
                                            <i class="fas fa-users me-1"></i> {{ $emploi->formation->elevesActifs()->count() }} élèves
                                        </div>
                                        <div>
                                            <i class="fas fa-door-open me-1"></i> {{ $emploi->salle->nom }}
                                        </div>
                                    </div>
                                    <div class="mt-3 d-flex justify-content-end">
                                        <a href="{{ route('emploi-du-temps.show', $emploi->id) }}" class="btn-modern btn-sm">
                                            <i class="fas fa-eye me-1"></i> Détails
                                        </a>
                                    </div>
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
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <div class="mt-4">
        <a href="{{ route('formateurs.show', $formateur->id) }}" class="btn-modern">
            <i class="fas fa-user me-1"></i> Profil du formateur
        </a>
        <a href="{{ route('formateurs.index') }}" class="btn-modern">
            <i class="fas fa-users me-1"></i> Liste des formateurs
        </a>
        <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
            <i class="fas fa-th me-1"></i> Vue générale
        </a>
        <a href="{{ route('home') }}" class="btn-modern">
            <i class="fas fa-home me-1"></i> Accueil
        </a>
    </div>
    
    <div class="mt-3">
        @include('components.back-button', ['url' => route('formateurs.index'), 'text' => 'Retour à la liste des formateurs'])
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
