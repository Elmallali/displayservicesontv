@extends('layouts.app')

@section('content')
<style>
    .detail-container {
        max-width: 700px;
        margin: 3rem auto;
        background: rgba(255, 255, 255, 0.05);
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        color: #f0f0f0;
    }

    .detail-container h2 {
        font-size: 1.6rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .detail-label {
        font-weight: bold;
        color: #ccc;
    }
</style>

<div class="detail-container">
    <h2>Détails du Formateur</h2>

    <div class="detail-item">
        <span class="detail-label">Nom:</span> {{ $formateur->nom }}
    </div>

    <div class="detail-item">
        <span class="detail-label">Spécialité:</span> {{ $formateur->specialite }}
    </div>

    <div class="detail-item">
        <span class="detail-label">Téléphone:</span> {{ $formateur->telephone ?? '---' }}
    </div>
</div>
@endsection
