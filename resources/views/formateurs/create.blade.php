@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 2rem;
        background: rgba(51, 148, 205, 0.18);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        color: #f0f0f0;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border-radius: 6px;
        border: none;
        outline: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3394cd, #82CEF9);
        color: white;
        padding: 10px 18px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #1c3139, #2a4b57);
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        text-align: center;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Ajouter un Formateur</h2>

    <form action="{{ route('formateurs.store') }}" method="POST">
        @csrf

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>

        <label for="specialite">Spécialité</label>
        <input type="text" name="specialite" id="specialite" required>

        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone">

        <button type="submit" class="btn-submit">Enregistrer</button>
    </form>
</div>
@endsection
