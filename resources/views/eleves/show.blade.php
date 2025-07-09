@extends('layouts.app')

@section('content')
<style>
    .section {
        max-width: 800px;
        margin: 3rem auto;
        background: rgba(255, 255, 255, 0.05);
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        color: #f0f0f0;
    }

    .section h2 {
        margin-bottom: 1rem;
        font-size: 1.6rem;
        font-weight: bold;
    }

    .section .info {
        margin-bottom: 10px;
        font-size: 1rem;
    }

    .paiement-entry {
        background: rgba(255,255,255,0.08);
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
</style>

<div class="section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin-bottom: 0;">Détails de l'élève</h2>
        <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn-modern">Modifier l'élève</a>
    </div>

    <div class="info"><strong>Nom:</strong> {{ $eleve->nom }}</div>
    <div class="info"><strong>Prénom:</strong> {{ $eleve->prenom }}</div>
    <div class="info"><strong>Sexe:</strong> {{ ucfirst($eleve->sexe) }}</div>
    <div class="info"><strong>Téléphone:</strong> {{ $eleve->telephone ?? '---' }}</div>
    <div class="info"><strong>Email:</strong> {{ $eleve->email ?? '---' }}</div>
    
    <div class="info">
        <strong>Formations:</strong>
        @if($eleve->formations->count() > 0)
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach($eleve->formations as $formation)
                    <li style="margin-bottom: 8px;">
                        <strong>{{ $formation->nom }}</strong> ({{ $formation->langue }} - {{ $formation->niveau_langue }})<br>
                        <small>Prix: {{ $formation->prix_mensuel }} DH/mois | Durée: {{ $formation->duree_mois }} mois</small>
                    </li>
                @endforeach
            </ul>
        @else
            <span>Aucune formation</span>
        @endif
    </div>

    <hr class="my-4">

    <h2>Paiements</h2>
    @if($eleve->paiements->isEmpty())
        <p>Aucun paiement enregistré.</p>
    @else
        @foreach($eleve->paiements as $paiement)
            <div class="paiement-entry">
                <div><strong>Mois:</strong> {{ $paiement->mois }}</div>
                <div><strong>Montant:</strong> {{ $paiement->montant }} DH</div>
                <div><strong>Date:</strong> {{ $paiement->date_paiement }}</div>
                <div><strong>Méthode:</strong> {{ $paiement->methode ?? '---' }}</div>
            </div>
        @endforeach
    @endif
</div>
@endsection
