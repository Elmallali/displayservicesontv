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
        max-width: 1000px;
        margin: auto;
    }

    .formateur-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
    }

    .formateur-card:hover {
        transform: translateY(-6px);
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
        <h2>Liste des Formateurs</h2>
        <a href="{{ route('formateurs.create') }}" class="btn-add">+ Ajouter Formateur</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($formateurs->isEmpty())
        <p>Aucun formateur trouvé.</p>
    @else
        @foreach($formateurs as $formateur)
            <div class="formateur-card">
                <div><strong>Nom:</strong> {{ $formateur->nom }}</div>
                <div><strong>Spécialité:</strong> {{ $formateur->specialite }}</div>
                <div><strong>Téléphone:</strong> {{ $formateur->telephone ?? '---' }}</div>

                <div class="d-flex justify-content-end mt-2">
                    <a href="{{ route('formateurs.show', $formateur->id) }}" class="btn-modern me-2">Voir</a>
                    <a href="{{ route('formateurs.edit', $formateur->id) }}" class="btn-modern me-2">Modifier</a>
                    <form action="{{ route('formateurs.destroy', $formateur->id) }}" method="POST" onsubmit="return confirm('Supprimer ce formateur ?')">
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
