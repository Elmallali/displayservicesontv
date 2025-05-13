@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📰 Liste des Nouveautés</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('news.create') }}" class="btn btn-primary mb-4">➕ Ajouter une nouveauté</a>

    <table class="table table-bordered table-striped bg-white text-dark">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Texte</th>
                <th>Durée (s)</th>
                <th>Active</th>
                <th>Créée le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($news as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->texte }}</td>
                    <td>{{ $item->duration }}s</td>
                    <td>
                        @if ($item->active)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('news.edit', $item) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form action="{{ route('news.destroy', $item) }}" method="POST" onsubmit="return confirm('Supprimer cette nouveauté ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($news->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted">Aucune nouveauté pour le moment.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
