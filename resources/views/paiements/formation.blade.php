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

    .formation-info {
        background: rgba(51, 148, 205, 0.3);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .formation-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--accent);
    }

    .formation-details {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }

    .formation-detail {
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

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(51, 148, 205, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #ddd;
    }

    .month-filter {
        background: rgba(51, 148, 205, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .month-filter .form-select {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
        border-radius: 8px;
        padding: 10px 15px;
    }
</style>

<div class="modern-container">
    <div class="header-actions">
        <h2>Paiements de la formation</h2>
        <div>
            <a href="{{ route('formations.index') }}" class="btn-modern">
                <i class="bi bi-arrow-left me-1"></i>Retour aux formations
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

    <div class="formation-info">
        <div class="formation-name">{{ $formation->nom }}</div>
        <div class="formation-details">
            <div class="formation-detail">
                <i class="bi bi-bar-chart-steps me-1"></i>
                Niveau: {{ $formation->niveau }}
            </div>
            
            <div class="formation-detail">
                <i class="bi bi-person-badge me-1"></i>
                Formateur: {{ $formation->formateur->nom }}
            </div>
            
            <div class="formation-detail">
                <i class="bi bi-cash-coin me-1"></i>
                Prix: {{ $formation->prix_mensuel }} DH/mois
            </div>
            
            <div class="formation-detail">
                <i class="bi bi-people me-1"></i>
                Élèves: {{ $formation->eleves->count() }}
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-value">{{ $totalPaiements }}</div>
            <div class="stat-label">Total des paiements</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value">{{ $paiementsConfirmes }}</div>
            <div class="stat-label">Paiements confirmés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value">{{ $paiementsNonConfirmes }}</div>
            <div class="stat-label">Paiements non confirmés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-value">{{ number_format($montantTotal, 2) }} DH</div>
            <div class="stat-label">Montant total</div>
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
    <div class="month-filter">
        <form action="{{ route('paiements.formation', $formation->id) }}" method="GET" class="row align-items-end">
            <div class="col-md-4">
                <label for="mois" class="form-label">Filtrer par mois</label>
                <select name="mois" id="mois" class="form-select" onchange="this.form.submit()">
                    <option value="">Tous les mois</option>
                    @foreach($moisDisponibles as $mois)
                        <option value="{{ $mois }}" {{ request('mois') == $mois ? 'selected' : '' }}>{{ $mois }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    @endif

    <div class="paiement-card">
        <div class="card-header">
            <h3>Liste des paiements</h3>
        </div>
        <div class="card-body">
            @if($paiements->isEmpty())
                <p class="p-3">Aucun paiement enregistré pour cette formation.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Élève</th>
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
                                    <td>
                                        <a href="{{ route('paiements.eleve', $paiement->eleve->id) }}" class="text-info">
                                            {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}
                                        </a>
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
