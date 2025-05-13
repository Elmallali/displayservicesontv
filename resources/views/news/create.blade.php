@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Ajouter une nouveauté</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('news.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="texte" class="form-label">Texte du news</label>
            <input type="text" name="texte" id="texte" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Durée d’affichage (secondes)</label>
            <input type="number" name="duration" id="duration" class="form-control" value="30">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="active" id="active" checked>
            <label class="form-check-label" for="active">Afficher immédiatement</label>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter la nouveauté</button>
    </form>
</div>
@endsection
