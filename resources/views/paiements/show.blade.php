@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
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
        max-width: 1000px;
        margin: auto;
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

    .card-header {
        background: rgba(51, 148, 205, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
    }

    .card-body {
        padding: 30px;
    }

    .paiement-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--accent);
    }

    .paiement-subtitle {
        font-size: 1.1rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 15px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 180px;
        font-weight: 600;
        color: #aaa;
    }

    .detail-value {
        flex: 1;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
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
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: background 0.3s, color 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-modern:hover {
        background: var(--accent);
        color: #fff;
    }

    .btn-danger {
        border-color: #ff4757;
        color: #ff4757;
    }

    .btn-danger:hover {
        background: #ff4757;
        color: #fff;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .action-buttons {
        margin-top: 30px;
        display: flex;
        justify-content: flex-end;
    }

    .receipt-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }

    .receipt-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--accent);
    }

    .receipt-info {
        font-style: italic;
        color: #aaa;
        margin-bottom: 15px;
    }

    .print-btn {
        margin-top: 15px;
    }
</style>

<div class="modern-container">
    <div class="header-actions">
        <h2>Détails du Paiement</h2>
        <div>
            <a href="{{ route('paiements.index') }}" class="btn-modern">
                <i class="bi bi-arrow-left me-1"></i>Retour aux paiements
            </a>
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    <div class="paiement-card">
        <div class="card-header">
            <div class="paiement-title">
                Paiement #{{ $paiement->id }}
                @if($paiement->est_confirme)
                    <span class="badge badge-success ms-2">Confirmé</span>
                @else
                    <span class="badge badge-danger ms-2">Non confirmé</span>
                @endif
            </div>
            <div class="paiement-subtitle">
                {{ $paiement->montant }} DH - {{ $paiement->mois }}
            </div>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <div class="detail-label">Élève</div>
                <div class="detail-value">
                    <a href="{{ route('paiements.eleve', $paiement->eleve->id) }}" class="text-info">
                        {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}
                    </a>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Formation</div>
                <div class="detail-value">
                    @if($paiement->formation)
                        <a href="{{ route('paiements.formation', $paiement->formation->id) }}" class="text-info">
                            {{ $paiement->formation->nom }} ({{ $paiement->formation->niveau }})
                        </a>
                    @else
                        <span class="text-muted">Non spécifiée</span>
                    @endif
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Mois</div>
                <div class="detail-value">{{ $paiement->mois }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Montant</div>
                <div class="detail-value">{{ $paiement->montant }} DH</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Date de paiement</div>
                <div class="detail-value">{{ Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Méthode</div>
                <div class="detail-value">{{ $paiement->methode ?? 'Non spécifiée' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Statut</div>
                <div class="detail-value">
                    @if($paiement->est_confirme)
                        <span class="badge badge-success">Confirmé</span>
                    @else
                        <span class="badge badge-danger">Non confirmé</span>
                    @endif
                </div>
            </div>
            
            @if($paiement->commentaire)
            <div class="detail-row">
                <div class="detail-label">Commentaire</div>
                <div class="detail-value">{{ $paiement->commentaire }}</div>
            </div>
            @endif
            
            <div class="detail-row">
                <div class="detail-label">Créé le</div>
                <div class="detail-value">{{ Carbon::parse($paiement->created_at)->format('d/m/Y à H:i') }}</div>
            </div>
            
            @if($paiement->updated_at != $paiement->created_at)
            <div class="detail-row">
                <div class="detail-label">Dernière modification</div>
                <div class="detail-value">{{ Carbon::parse($paiement->updated_at)->format('d/m/Y à H:i') }}</div>
            </div>
            @endif

            @if(Auth::user()->role === 'admin')
            <div class="receipt-section">
                <div class="receipt-title">Reçu de paiement</div>
                <div class="receipt-info">
                    Un reçu peut être imprimé pour ce paiement. Il contiendra toutes les informations nécessaires pour l'élève.
                </div>
                <a href="#" class="btn-modern print-btn" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Imprimer le reçu
                </a>
            </div>
            
            <div class="action-buttons">
                <form action="{{ route('paiements.toggleConfirmation', $paiement->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-modern">
                        @if($paiement->est_confirme)
                            <i class="bi bi-x-circle me-1"></i>Annuler la confirmation
                        @else
                            <i class="bi bi-check-circle me-1"></i>Confirmer le paiement
                        @endif
                    </button>
                </form>
                
                <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn-modern">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
                
                <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-danger">
                        <i class="bi bi-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
