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

    .badge-available {
        background-color: rgba(46, 204, 113, 0.2);
        color: #2ecc71;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .badge-unavailable {
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
</style>

<div class="page-container">
    <h1 class="page-title">Gestion des Salles</h1>
    
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
        <a href="{{ route('salles.create') }}" class="btn-add">
            <i class="fas fa-plus-circle me-1"></i> Ajouter une nouvelle salle
        </a>
    @endif
    
    <div class="card-modern">
        @if($salles->count() > 0)
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Étage</th>
                            <th>Capacité</th>
                            <th>Statut</th>
                            <th>Formation Actuelle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salles as $salle)
                            <tr>
                                <td>{{ $salle->nom }}</td>
                                <td>{{ $salle->etage ?? 'Non spécifié' }}</td>
                                <td>{{ $salle->capacite }} personnes</td>
                                <td>
                                    @if($salle->est_disponible)
                                        <span class="badge-available">Disponible</span>
                                    @else
                                        <span class="badge-unavailable">Non disponible</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $formationActuelle = $salle->formationActuelle();
                                    @endphp
                                    
                                    @if($formationActuelle)
                                        <strong>{{ $formationActuelle->nom }}</strong>
                                    @else
                                        <span class="text-muted">Aucune formation en cours</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('salles.show', $salle->id) }}" class="action-btn" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('salles.edit', $salle->id) }}" class="action-btn" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="#" class="action-btn delete-btn" title="Supprimer" 
                                           onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')) document.getElementById('delete-salle-{{ $salle->id }}').submit();">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        
                                        <form id="delete-salle-{{ $salle->id }}" action="{{ route('salles.destroy', $salle->id) }}" method="POST" style="display: none;">
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
                    <i class="fas fa-door-open"></i>
                </div>
                <p class="empty-text">Aucune salle n'a été ajoutée pour le moment.</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('salles.create') }}" class="btn-modern">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter une salle
                    </a>
                @endif
            </div>
        @endif
    </div>
    
    <div class="mt-4">
        <a href="{{ route('emploi-du-temps.index') }}" class="btn-modern">
            <i class="fas fa-calendar-alt me-1"></i> Voir l'emploi du temps
        </a>
        <a href="{{ route('home') }}" class="btn-modern">
            <i class="fas fa-home me-1"></i> Accueil
        </a>
    </div>
    
    <div class="mt-3">
        @include('components.back-button', ['url' => route('home'), 'text' => 'Retour à l\'accueil'])
    </div>
</div>
@endsection
