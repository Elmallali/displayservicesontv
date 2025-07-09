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

    .btn-add {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.4s ease;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .btn-add:hover {
        background: var(--hover-gradient);
        color: white;
        text-decoration: none;
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
    <h1 class="page-title">Emploi du Temps</h1>
    
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
    
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('emploi-du-temps.create') }}" class="btn-add">
            <i class="fas fa-plus-circle me-1"></i> Ajouter un nouvel horaire
        </a>
    @endif
    
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
                                            <i class="fas fa-chalkboard-teacher me-1"></i> {{ $emploi->formation->formateur->nom }}
                                        </div>
                                        <div>
                                            <i class="fas fa-door-open me-1"></i> {{ $emploi->salle->nom }}
                                        </div>
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
    </div>
    
    <div class="mt-4">
        <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
            <i class="fas fa-list me-1"></i> Vue liste
        </a>
        <a href="{{ route('salles.index') }}" class="btn-modern">
            <i class="fas fa-door-open me-1"></i> Gestion des salles
        </a>
        <a href="{{ route('formations.index') }}" class="btn-modern">
            <i class="fas fa-graduation-cap me-1"></i> Gestion des formations
        </a>
        <a href="{{ route('home') }}" class="btn-modern">
            <i class="fas fa-home me-1"></i> Retour à l'accueil
        </a>
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
