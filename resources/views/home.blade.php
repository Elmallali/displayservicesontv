@extends('layouts.app')

@section('content')
<style>
    body, html {
        height: 100%;
        margin: 0;
        background: #1c3139;
        color: #f0f0f0;
        font-family: 'Segoe UI', sans-serif;
    }

    .welcome-screen {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 60px 20px;   /* espace sous navbar */
    }

    .logo {
        height: 100px;
        margin-bottom: 60px;
    }

    .cards-container {
        display: flex;
        gap: 60px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 10px;
        justify-content: center;
    }
    .cards-container::-webkit-scrollbar { display: none; }

    .card-link {
        flex: 0 0 280px;
        background: #3394cd;
        color: #fff;
        border-radius: 12px;
        padding: 30px 20px;
        text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    }
    .card-link:hover {
        transform: translateY(-6px);
        background: #1c3139;
        box-shadow: 0 8px 25px rgba(0,0,0,0.7);
    }
    .card-link h2 {
        font-size: 1.5rem;
        margin-bottom: 12px;
        font-weight: 600;
    }
    .card-link p {
        font-size: 1rem;
        color: #ccc;
    }

    .bottom-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #aaa;
    }
</style>

<div class="welcome-screen">
    {{-- Logo au-dessus --}}
    <img src="{{ asset('assests/logo.png') }}" alt="Logo Centre" class="logo">

    {{-- Cards horizontales --}}
    <div class="cards-container">
        <a href="{{ route('public') }}" class="card-link">
            <h2>🎬 Écran Public</h2>
            <p>Voir le slideshow en direct.</p>
        </a>
        <a href="{{ route('services.index') }}" class="card-link">
            <h2>📚 Services</h2>
            <p>Découvrez tous nos cours.</p>
        </a>
        @auth
            <a href="{{ route('profile.show') }}" class="card-link">
                <h2>👤 Mon Compte</h2>
                <p>Gérez votre profil.</p>
            </a>
        @else
            <a href="{{ route('login') }}" class="card-link">
                <h2>🔐 Connexion</h2>
                <p>Accédez à votre espace.</p>
            </a>
            <a href="{{ route('register') }}" class="card-link">
                <h2>📝 Inscription</h2>
                <p>Rejoignez‑nous.</p>
            </a>
        @endauth
    </div>

    {{-- Titre en bas --}}
    <div class="bottom-title">
        Centre de Langues – Apprenez et progressez avec nous !
    </div>
</div>
@endsection
