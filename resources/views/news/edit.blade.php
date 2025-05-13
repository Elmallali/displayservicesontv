@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">✏️ Modifier la nouveauté</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('news.update', $news) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="texte" class="form-label">Texte du news</label>
            <input type="text" name="texte" id="texte" class="form-control"
                   value="{{ old('texte', $news->texte) }}" required>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Durée d’affichage (secondes)</label>
            <input type="number" name="duration" id="duration" class="form-control"
                   value="{{ old('duration', $news->duration) }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="active" id="active"
                   {{ $news->active ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Afficher immédiatement</label>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('news.index') }}" class="btn btn-secondary">↩ Retour</a>
            <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
        </div>
    </form>
</div>
@endsection
