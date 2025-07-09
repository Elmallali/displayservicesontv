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

    .eleve-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .eleve-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
    }

    .eleve-info {
        margin-bottom: 10px;
    }

    .btn-modern {
        border: 1px solid var(--accent);
        background: transparent;
        color: var(--accent);
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: background 0.3s, color 0.3s;
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
        <h2>Gestion des Élèves</h2>
        <a href="{{ route('eleves.create') }}" class="btn-add">+ Ajouter un élève</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($eleves->isEmpty())
        <p>Aucun élève trouvé.</p>
    @else
        @foreach ($eleves as $eleve)
            <div class="eleve-card">
                <div class="eleve-info"><strong>Nom:</strong> {{ $eleve->nom }} {{ $eleve->prenom }}</div>
                <div class="eleve-info"><strong>Sexe:</strong> {{ ucfirst($eleve->sexe) }}</div>
                <div class="eleve-info"><strong>Téléphone:</strong> {{ $eleve->telephone ?? '---' }}</div>
                <div class="eleve-info"><strong>Email:</strong> {{ $eleve->email ?? '---' }}</div>
                <div class="eleve-info"><strong>Formations:</strong> 
                    @if($eleve->formations->count() > 0)
                        <ul style="margin-top: 5px; padding-left: 20px;">
                            @foreach($eleve->formations as $formation)
                                <li>{{ $formation->nom }} ({{ $formation->langue }} - {{ $formation->niveau_langue }})</li>
                            @endforeach
                        </ul>
                    @else
                        <span>Aucune formation</span>
                    @endif
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('eleves.show', $eleve) }}" class="btn-modern me-2">Voir</a>
                    <a href="{{ route('eleves.edit', $eleve) }}" class="btn-modern me-2" style="background: rgba(51, 148, 205, 0.3);">Modifier</a>

                    <form action="{{ route('eleves.destroy', $eleve) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-modern">Supprimer</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
