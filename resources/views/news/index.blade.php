@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #3563E9;
        --accent: #4FBAEE;
        --background: #1C3139;
        --card-bg: rgba(255, 255, 255, 0.05);
        --text: #f0f0f0;
        --gradient: linear-gradient(135deg, #3394cd, #82CEF9);
    }

    body {
        background: var(--background);
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .container-news {
        max-width: 1150px;
        margin: 3rem auto;
        background: var(--card-bg);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .news-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .news-header h2 {
        font-size: 1.7rem;
        font-weight: 700;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .news-header a.back-link {
        display: inline-block;
        color: #ccc;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .news-header a.back-link:hover {
        text-decoration: underline;
    }

    .btn-add {
        background: var(--gradient);
        color: white;
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.4s ease;
    }

    .btn-add:hover {
        background: #2a4b57;
    }

    .alert {
        background: rgba(25, 135, 84, 0.1);
        color: #89f6c2;
        border-left: 4px solid #4ae1a0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    table {
        width: 100%;
        border-spacing: 0 10px;
        border-collapse: separate;
    }

    thead {
        background-color: rgba(255,255,255,0.05);
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
        font-size: 0.95rem;
    }

    thead th {
        font-weight: 600;
        color: #ccc;
    }

    tbody tr {
        background: rgba(255,255,255,0.025);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        background: rgba(255,255,255,0.04);
    }

    tbody td {
        color: #eee;
        vertical-align: middle;
    }

    tbody td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    tbody td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-active {
        background-color: rgba(25, 135, 84, 0.15);
        color: #80f3b4;
    }

    .badge-inactive {
        background-color: rgba(180, 180, 180, 0.1);
        color: #aaa;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .btn-edit {
        color: #4FBAEE;
        border-color: #4FBAEE;
    }

    .btn-edit:hover {
        background: rgba(79, 186, 238, 0.15);
    }

    .btn-delete {
        color: #ff6b6b;
        border-color: #ff6b6b;
    }

    .btn-delete:hover {
        background: rgba(255, 107, 107, 0.15);
    }

</style>

<div class="container-news">
    <div class="news-header">
        <div>
            <h2>📰 Liste des Nouveautés</h2>
            <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left me-1"></i>Retour à l'accueil</a>
        </div>
        <a href="{{ route('news.create') }}" class="btn-add">
            <i class="bi bi-plus-circle"></i> Ajouter
        </a>
    </div>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Texte</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Date de création</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->texte }}</td>
                        <td>{{ $item->duration }} sec</td>
                        <td>
                            <form action="{{ route('news.toggleActive', $item) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="badge {{ $item->active ? 'badge-active' : 'badge-inactive' }} border-0">
                                    <i class="bi {{ $item->active ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                                    {{ $item->active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('news.edit', $item) }}" class="btn-action btn-edit" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('news.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette nouveauté?')" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
