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
        <h2>Liste des Paiements</h2>
        <div>
            <a href="{{ route('home') }}" class="btn-modern me-2">
                <i class="bi bi-house-door me-1"></i>Accueil
            </a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('paiements.create') }}" class="btn-add">
                <i class="bi bi-plus-lg me-1"></i>Nouveau Paiement
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="paiement-card mb-4">
        <div class="card-header">
            <h3>Filtres</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('paiements.index') }}" method="GET" class="row">
                <div class="col-md-3 mb-3">
                    <label for="mois" class="form-label">Mois</label>
                    <input type="text" name="mois" id="mois" class="form-control" value="{{ request('mois') }}" placeholder="Ex: Mai 2025">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="eleve_id" class="form-label">Élève</label>
                    <select name="eleve_id" id="eleve_id" class="form-select">
                        <option value="">Tous les élèves</option>
                        @foreach(\App\Models\Eleve::orderBy('nom')->get() as $eleve)
                            <option value="{{ $eleve->id }}" {{ request('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                {{ $eleve->nom }} {{ $eleve->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="formation_id" class="form-label">Formation</label>
                    <select name="formation_id" id="formation_id" class="form-select">
                        <option value="">Toutes les formations</option>
                        @foreach(\App\Models\Formation::orderBy('nom')->get() as $formation)
                            <option value="{{ $formation->id }}" {{ request('formation_id') == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="est_confirme" class="form-label">Statut</label>
                    <select name="est_confirme" id="est_confirme" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="1" {{ request('est_confirme') === '1' ? 'selected' : '' }}>Confirmés</option>
                        <option value="0" {{ request('est_confirme') === '0' ? 'selected' : '' }}>Non confirmés</option>
                    </select>
                </div>
                
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn-modern me-2">
                        <i class="bi bi-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('paiements.index') }}" class="btn-modern">
                        <i class="bi bi-x-circle me-1"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($paiements->isEmpty())
        <div class="alert alert-info">Aucun paiement ne correspond à vos critères de recherche.</div>
    @else
        <div class="paiement-card">
            <div class="card-header">
                <h3>Liste des paiements ({{ $paiements->count() }})</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Élève</th>
                                <th>Formation</th>
                                <th>Mois</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Méthode</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paiements as $paiement)
                                <tr>
                                    <td>
                                        <a href="{{ route('paiements.eleve', $paiement->eleve->id) }}" class="text-info">
                                            {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($paiement->formation)
                                            <a href="{{ route('paiements.formation', $paiement->formation->id) }}" class="text-info">
                                                {{ $paiement->formation->nom }}
                                            </a>
                                        @else
                                            <span class="text-muted">Non spécifiée</span>
                                        @endif
                                    </td>
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
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn-modern btn-sm">
                                                <i class="bi bi-eye me-1"></i>Détails
                                            </a>
                                            
                                            @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('paiements.toggleConfirmation', $paiement->id) }}" method="POST" class="d-inline ms-1">
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
                                                
                                                <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn-modern btn-sm ms-1">
                                                    <i class="bi bi-pencil me-1"></i>Modifier
                                                </a>
                                                
                                                <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-modern btn-sm">
                                                        <i class="bi bi-trash me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
