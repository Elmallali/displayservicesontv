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

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: var(--text);
    }

    .table-modern th {
        background-color: rgba(51, 148, 205, 0.3);
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-modern th:first-child {
        border-top-left-radius: 10px;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-modern th:last-child {
        border-top-right-radius: 10px;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-modern td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table-modern tr:last-child td {
        border-bottom: none;
    }

    .table-modern tr:hover td {
        background-color: rgba(255, 255, 255, 0.05);
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

    .action-btn {
        color: var(--accent);
        margin-right: 10px;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }

    .action-btn:hover {
        transform: scale(1.2);
    }

    .delete-btn {
        color: #e74c3c;
    }

    .empty-state {
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
</style>

<div class="page-container">
    <h1 class="page-title">Gestion de l'Emploi du Temps</h1>
    
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
    
    <div class="card-modern">
        @if($emploiDuTemps->count() > 0)
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Formation</th>
                            <th>Salle</th>
                            <th>Jour</th>
                            <th>Horaire</th>
                            <th>Période</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emploiDuTemps as $emploi)
                            <tr>
                                <td>
                                    <strong>{{ $emploi->formation->nom }}</strong><br>
                                    <small>{{ $emploi->formation->niveau_langue }} - {{ ucfirst($emploi->formation->langue) }}</small>
                                </td>
                                <td>{{ $emploi->salle->nom }}</td>
                                <td><span class="day-badge">{{ $emploi->jour }}</span></td>
                                <td><span class="time-badge">{{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}</span></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($emploi->date_debut)->format('d/m/Y') }} 
                                    @if($emploi->date_fin)
                                        - {{ \Carbon\Carbon::parse($emploi->date_fin)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">(illimitée)</span>
                                    @endif
                                </td>
                                <td>
                                    @if($emploi->est_actif)
                                        <span class="badge-active">Actif</span>
                                    @else
                                        <span class="badge-inactive">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('emploi-du-temps.show', $emploi->id) }}" class="action-btn" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('emploi-du-temps.edit', $emploi->id) }}" class="action-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="#" class="action-btn delete-btn" title="Supprimer" 
                                           onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?')) document.getElementById('delete-emploi-{{ $emploi->id }}').submit();">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        
                                        <form id="delete-emploi-{{ $emploi->id }}" action="{{ route('emploi-du-temps.destroy', $emploi->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p class="empty-text">Aucun horaire n'a été ajouté pour le moment.</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('emploi-du-temps.create') }}" class="btn-modern">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter un horaire
                    </a>
                @endif
            </div>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
            <i class="fas fa-th me-1"></i> Vue par jour
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
@endsection

