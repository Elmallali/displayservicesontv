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
        --hover-gradient: linear-gradient(135deg, #1c3139, #2a4b57);
    }

    body {
        background: var(--background);
        font-family: 'Segoe UI', sans-serif;
        color: var(--text);
    }

    .profile-card {
        max-width: 650px;
        margin: 3rem auto;
        background: var(--card-bg);
        border-radius: 18px;
        padding: 2.5rem 2rem;
        text-align: center;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .profile-card h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-card p {
        color: #bbb;
        margin-bottom: 1.5rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-bottom: 1.2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .btn-gradient {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .btn-gradient:hover {
        background: var(--hover-gradient);
    }

    .btn-outline-light {
        border: 1px solid #aaa;
        color: #ccc;
        padding: 10px 18px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.05);
    }

    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .profile-header h5 {
        font-size: 1.2rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
    }
</style>

<div class="profile-card">
    <div class="profile-header">
        <h5>👤 Mon Profil</h5>
        <a href="{{ route('home') }}" class="btn-outline-light btn-sm">Retour</a>
    </div>

    {{-- Avatar --}}
    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0044cc&color=fff&size=120"
         class="profile-avatar" alt="avatar">

    {{-- User Info --}}
    <h4>{{ Auth::user()->name }}</h4>
    <p>{{ Auth::user()->email }}</p>

    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

    {{-- Action Buttons --}}
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('profile.edit') }}" class="btn-gradient">
            <i class="bi bi-pencil me-1"></i> Modifier mes informations
        </a>
        <a href="{{ route('profile.password.form') }}" class="btn-outline-light">
            <i class="bi bi-lock me-1"></i> Changer le mot de passe
        </a>
    </div>
</div>
@endsection
