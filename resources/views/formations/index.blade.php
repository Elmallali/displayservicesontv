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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        height: 100%;
    }

    .formation-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.4);
    }

    .formation-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .formation-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .formation-desc {
        font-size: 1rem;
        color: #ddd;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .formation-details {
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .formation-details span {
        display: inline-block;
        margin-right: 15px;
        padding: 4px 8px;
        background: rgba(51, 148, 205, 0.3);
        border-radius: 4px;
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
        margin-bottom: 5px;
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
</style>

<div class="modern-container">
    <div class="header-actions">
        <h2>Gestion des Formations</h2>
        @if(Auth::user()->role === 'admin')
        <a href="{{ route('formations.create') }}" class="btn-add">+ Ajouter une Formation</a>
        @endif
    </div>
    
    <div class="header-actions">
        <a href="{{ route('home') }}" class="text-decoration-none text-secondary mt-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i>Retour
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($formations->isEmpty())
        <p>Aucune formation trouvée.</p>
    @else
        <div class="row">
            @foreach ($formations as $formation)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="formation-card">
                        <div class="formation-body">
                            <div class="formation-title">{{ $formation->nom }}</div>
                            <div class="formation-desc">{{ $formation->description }}</div>
                            
                            <div class="formation-details">
                                <span><i class="bi bi-tag-fill me-1"></i>{{ $formation->niveau }}</span>
                                <span><i class="bi bi-cash me-1"></i>{{ $formation->prix_mensuel }} DH/mois</span>
                                <span><i class="bi bi-calendar-event me-1"></i>{{ $formation->duree_mois }} mois</span>
                            </div>
                            
                            <div class="formation-details">
                                <span><i class="bi bi-person-fill me-1"></i>{{ $formation->formateur->nom }}</span>
                                <span><i class="bi bi-book me-1"></i>{{ $formation->formateur->specialite }}</span>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between mt-2">
                                <a href="{{ route('formations.show', $formation->id) }}" class="btn-modern">
                                    <i class="bi bi-eye me-1"></i>Détails
                                </a>
                                
                                <a href="{{ route('formations.eleves', $formation->id) }}" class="btn-modern">
                                    <i class="bi bi-people me-1"></i>Élèves
                                </a>
                                
                                <a href="{{ route('paiements.formation', $formation->id) }}" class="btn-modern">
                                    <i class="bi bi-cash-stack me-1"></i>Paiements
                                </a>
                                
                                @if(Auth::user()->role === 'admin')
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
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
