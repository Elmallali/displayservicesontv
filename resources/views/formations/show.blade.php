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

    .formation-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        padding: 30px;
        margin-bottom: 30px;
    }

    .formation-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--accent);
    }

    .formation-section {
        margin-bottom: 25px;
    }

    .formation-section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 10px;
    }

    .formation-detail {
        display: flex;
        margin-bottom: 10px;
    }

    .formation-detail-label {
        width: 150px;
        font-weight: 500;
        color: #aaa;
    }

    .formation-detail-value {
        flex-grow: 1;
    }

    .btn-modern {
        border: 1px solid var(--accent);
        background: transparent;
        color: var(--accent);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: background 0.3s, color 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-modern:hover {
        background: var(--accent);
        color: #fff;
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
        <h2>Détails de la Formation</h2>
        <a href="{{ route('formations.index') }}" class="btn-modern">
            <i class="bi bi-arrow-left me-1"></i>Retour aux formations
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="formation-card">
        <div class="formation-title">{{ $formation->nom }}</div>
        
        <div class="formation-section">
            <div class="formation-section-title">Informations générales</div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Description</div>
                <div class="formation-detail-value">{{ $formation->description ?: 'Non spécifiée' }}</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Niveau</div>
                <div class="formation-detail-value">{{ $formation->niveau }}</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Prix mensuel</div>
                <div class="formation-detail-value">{{ $formation->prix_mensuel }} DH</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Durée</div>
                <div class="formation-detail-value">{{ $formation->duree_mois }} mois</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Date de création</div>
                <div class="formation-detail-value">{{ $formation->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="formation-section">
            <div class="formation-section-title">Formateur</div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Nom</div>
                <div class="formation-detail-value">{{ $formation->formateur->nom }}</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Spécialité</div>
                <div class="formation-detail-value">{{ $formation->formateur->specialite }}</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Téléphone</div>
                <div class="formation-detail-value">{{ $formation->formateur->telephone ?: 'Non spécifié' }}</div>
            </div>
        </div>
        
        <div class="formation-section">
            <div class="formation-section-title">Statistiques</div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Élèves inscrits</div>
                <div class="formation-detail-value">{{ $formation->eleves->count() }}</div>
            </div>
            
            <div class="formation-detail">
                <div class="formation-detail-label">Élèves actifs</div>
                <div class="formation-detail-value">{{ $formation->eleves->where('pivot.statut', 'actif')->count() }}</div>
            </div>
        </div>
        
        <div class="d-flex mt-4">
            <a href="{{ route('formations.eleves', $formation->id) }}" class="btn-modern">
                <i class="bi bi-people me-1"></i>Voir les élèves
            </a>
            
            <a href="{{ route('paiements.formation', $formation->id) }}" class="btn-modern">
                <i class="bi bi-cash-stack me-1"></i>Voir les paiements
            </a>
            
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('formations.inscription.form', $formation->id) }}" class="btn-modern">
                <i class="bi bi-person-plus me-1"></i>Inscrire un élève
            </a>
            
            <a href="{{ route('formations.edit', $formation->id) }}" class="btn-modern">
                <i class="bi bi-pencil me-1"></i>Modifier
            </a>
            
            <form action="{{ route('formations.destroy', $formation->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modern" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?')">
                    <i class="bi bi-trash me-1"></i>Supprimer
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
