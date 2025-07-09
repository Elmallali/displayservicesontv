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

    .formation-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        margin-bottom: 30px;
    }

    .formation-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--accent);
    }

    .formation-subtitle {
        font-size: 1rem;
        color: #ddd;
        margin-bottom: 0;
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

    .badge-warning {
        background-color: rgba(255, 165, 2, 0.2);
        color: #ffa502;
        border: 1px solid rgba(255, 165, 2, 0.4);
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
        padding: 8px 16px;
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
        margin-bottom: 1.5rem;
    }

    .form-select {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.9rem;
        width: auto;
        display: inline-block;
    }
</style>

<div class="modern-container">
    <div class="header-actions">
        <h2>Élèves inscrits à la formation</h2>
        <div>
            <a href="{{ route('formations.show', $formation->id) }}" class="btn-modern">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('formations.inscription.form', $formation->id) }}" class="btn-add">
                <i class="bi bi-person-plus me-1"></i>Inscrire un élève
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

    <div class="formation-card">
        <div class="card-header">
            <div class="formation-title">{{ $formation->nom }}</div>
            <div class="formation-subtitle">
                <span class="me-3"><i class="bi bi-tag-fill me-1"></i>{{ $formation->niveau }}</span>
                <span class="me-3"><i class="bi bi-cash me-1"></i>{{ $formation->prix_mensuel }} DH/mois</span>
                <span><i class="bi bi-person-fill me-1"></i>{{ $formation->formateur->nom }}</span>
            </div>
        </div>
        
        <div class="card-body">
            @if ($formation->eleves->isEmpty())
                <div class="p-4 text-center">
                    <p>Aucun élève inscrit à cette formation.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Contact</th>
                                <th>Date d'inscription</th>
                                <th>Statut</th>
                                <th>Paiement du mois</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formation->eleves as $eleve)
                                <tr>
                                    <td>{{ $eleve->nom }}</td>
                                    <td>{{ $eleve->prenom }}</td>
                                    <td>
                                        @if ($eleve->telephone)
                                            <i class="bi bi-telephone me-1"></i>{{ $eleve->telephone }}<br>
                                        @endif
                                        @if ($eleve->email)
                                            <i class="bi bi-envelope me-1"></i>{{ $eleve->email }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($eleve->pivot->date_inscription)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($eleve->pivot->statut === 'actif')
                                            <span class="badge badge-success">Actif</span>
                                        @elseif ($eleve->pivot->statut === 'suspendu')
                                            <span class="badge badge-warning">Suspendu</span>
                                        @else
                                            <span class="badge badge-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($eleve->aPayePourMoisCourant($formation))
                                            <span class="badge badge-success">Payé</span>
                                        @else
                                            <span class="badge badge-danger">Non payé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('eleves.paiements', $eleve->id) }}" class="btn-modern btn-sm">
                                                <i class="bi bi-cash-stack me-1"></i>Paiements
                                            </a>
                                            
                                            @if(Auth::user()->role === 'admin')
                                                <form action="{{ route('formations.eleves.statut', [$formation->id, $eleve->id]) }}" method="POST" class="d-inline ms-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="statut" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="actif" {{ $eleve->pivot->statut === 'actif' ? 'selected' : '' }}>Actif</option>
                                                        <option value="suspendu" {{ $eleve->pivot->statut === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                                        <option value="inactif" {{ $eleve->pivot->statut === 'inactif' ? 'selected' : '' }}>Inactif</option>
                                                    </select>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
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
