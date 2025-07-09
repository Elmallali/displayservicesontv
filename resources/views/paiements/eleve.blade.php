@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

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
        max-width: 1200px;
        margin: auto;
    }

    .card-header {
        background: rgba(51, 148, 205, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px 20px;
    }

    .card-body {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 0 0 15px 15px;
    }

    .paiement-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        margin-bottom: 30px;
    }

    .eleve-info {
        background: rgba(51, 148, 205, 0.3);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .eleve-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--accent);
    }

    .eleve-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .eleve-detail {
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .table {
        color: var(--text);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .table th {
        border-top: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background-color: rgba(51, 148, 205, 0.2);
        padding: 12px 15px;
    }

    .table td {
        border-color: rgba(255, 255, 255, 0.1);
        padding: 12px 15px;
        vertical-align: middle;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .badge-success {
        background-color: rgba(46, 213, 115, 0.2);
        color: #2ed573;
        border: 1px solid rgba(46, 213, 115, 0.4);
    }

    .badge-danger {
        background-color: rgba(255, 71, 87, 0.2);
        color: #ff4757;
        border: 1px solid rgba(255, 71, 87, 0.4);
    }

    .btn-modern {
        border: 1px solid var(--accent);
        background: transparent;
        color: var(--accent);
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: background 0.3s, color 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
    }

    .btn-modern:hover {
        background: var(--accent);
        color: #fff;
    }

    .btn-add {
        background: var(--gradient);
        color: white;
        padding: 10px 18px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        transition: background 0.4s ease;
        text-decoration: none;
    }

    .btn-add:hover {
        background: var(--hover-gradient);
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
</style>

<div class="modern-container">
    <div class="header-actions">
        <h2>Paiements de l'élève</h2>
        <div>
            <a href="{{ route('eleves.index') }}" class="btn-modern">
                <i class="bi bi-arrow-left me-1"></i>Retour aux élèves
            </a>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('paiements.create') }}" class="btn-add">
                <i class="bi bi-plus-lg me-1"></i>Nouveau paiement
            </a>
            @endif
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="eleve-info">
        <div class="eleve-name">{{ $eleve->nom }} {{ $eleve->prenom }}</div>
        <div class="eleve-details">
            @if($eleve->sexe)
                <div class="eleve-detail">
                    <i class="bi {{ $eleve->sexe === 'homme' ? 'bi-gender-male' : 'bi-gender-female' }} me-1"></i>
                    {{ ucfirst($eleve->sexe) }}
                </div>
            @endif
            
            @if($eleve->langue_suivie)
                <div class="eleve-detail">
                    <i class="bi bi-translate me-1"></i>
                    {{ $eleve->langue_suivie }}
                </div>
            @endif
            
            @if($eleve->telephone)
                <div class="eleve-detail">
                    <i class="bi bi-telephone me-1"></i>
                    {{ $eleve->telephone }}
                </div>
            @endif
            
            @if($eleve->email)
                <div class="eleve-detail">
                    <i class="bi bi-envelope me-1"></i>
                    {{ $eleve->email }}
                </div>
            @endif
        </div>
    </div>

    <div class="paiement-card">
        <div class="card-header">
            <h3>Formations suivies</h3>
        </div>
        <div class="card-body">
            @if($eleve->formations->isEmpty())
                <p class="p-3">Cet élève n'est inscrit à aucune formation.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Formation</th>
                                <th>Niveau</th>
                                <th>Formateur</th>
                                <th>Prix mensuel</th>
                                <th>Date d'inscription</th>
                                <th>Statut</th>
                                <th>Paiement du mois</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eleve->formations as $formation)
                                <tr>
                                    <td>{{ $formation->nom }}</td>
                                    <td>{{ $formation->niveau }}</td>
                                    <td>{{ $formation->formateur->nom }}</td>
                                    <td>{{ $formation->prix_mensuel }} DH</td>
                                    <td>{{ \Carbon\Carbon::parse($formation->pivot->date_inscription)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($formation->pivot->statut === 'actif')
                                            <span class="badge badge-success">Actif</span>
                                        @elseif($formation->pivot->statut === 'suspendu')
                                            <span class="badge badge-warning">Suspendu</span>
                                        @else
                                            <span class="badge badge-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($eleve->aPayePourMoisCourant($formation))
                                            <span class="badge badge-success">Payé</span>
                                        @else
                                            <span class="badge badge-danger">Non payé</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="paiement-card">
        <div class="card-header">
            <h3>Historique des paiements</h3>
        </div>
        <div class="card-body">
            @if($paiements->isEmpty())
                <p class="p-3">Aucun paiement enregistré pour cet élève.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Formation</th>
                                <th>Mois</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Méthode</th>
                                <th>Statut</th>
                                @if(Auth::user()->role === 'admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paiements as $paiement)
                                <tr>
                                    <td>{{ $paiement->formation ? $paiement->formation->nom : 'Non spécifiée' }}</td>
                                    <td>{{ $paiement->mois }}</td>
                                    <td>{{ $paiement->montant }} DH</td>
                                    <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                                    <td>{{ $paiement->methode ?? '---' }}</td>
                                    <td>
                                        @if($paiement->est_confirme)
                                            <span class="badge badge-success">Confirmé</span>
                                        @else
                                            <span class="badge badge-danger">Non confirmé</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->role === 'admin')
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('paiements.toggleConfirmation', $paiement->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-modern btn-sm">
                                                    @if($paiement->est_confirme)
                                                        <i class="bi bi-x-circle me-1"></i>Annuler
                                                    @else
                                                        <i class="bi bi-check-circle me-1"></i>Confirmer
                                                    @endif
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn-modern btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Modifier
                                            </a>
                                            
                                            <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-modern btn-sm">
                                                    <i class="bi bi-trash me-1"></i>Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
