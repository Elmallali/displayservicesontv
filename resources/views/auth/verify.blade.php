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
        font-family: 'Segoe UI', sans-serif;
        color: var(--text);
    }

    .verify-container {
        max-width: 650px;
        margin: 3rem auto;
        background: var(--card-bg);
        border-radius: 18px;
        padding: 2.5rem 2rem;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .verify-title {
        font-size: 1.4rem;
        font-weight: 700;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .alert-success {
        background: rgba(25, 135, 84, 0.1);
        color: #89f6c2;
        border-left: 4px solid #4ae1a0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .resend-btn {
        background: none;
        border: none;
        padding: 0;
        color: #82CEF9;
        font-weight: 600;
        cursor: pointer;
        text-decoration: underline;
    }

    .resend-btn:hover {
        color: #fff;
    }
</style>

<div class="verify-container">
    <h2 class="verify-title">📧 Vérification de l'adresse e-mail</h2>

    @if (session('resent'))
        <div class="alert-success">
            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
        </div>
    @endif

    <p>
        Avant de continuer, veuillez vérifier votre boîte mail pour un lien de vérification.<br>
        Si vous n'avez pas reçu l'e-mail,
    </p>

    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="resend-btn">cliquez ici pour en recevoir un autre</button>.
    </form>
</div>
@endsection
