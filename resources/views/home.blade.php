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

    body, html {
        height: 100%;
        margin: 0;
        background: var(--background);
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .welcome-screen {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 3rem 1rem;
        position: relative;
        overflow: hidden;
    }

    .particles-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(79, 186, 238, 0.15);
        pointer-events: none;
    }

    .logo-container {
        position: relative;
        margin-bottom: 3rem;
        z-index: 1;
    }

    .logo {
        height: 280px;
        position: relative;
        z-index: 2;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .logo-glow {
        position: absolute;
        width: 120%;
        height: 120%;
        top: -10%;
        left: -10%;
        background: radial-gradient(circle, rgba(51, 148, 205, 0.5) 0%, rgba(51, 148, 205, 0) 70%);
        filter: blur(10px);
        opacity: 0;
        z-index: 1;
        pointer-events: none;
    }

    @keyframes float {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(2deg); }
        100% { transform: translateY(0) rotate(0deg); }
    }

    @keyframes glow-pulse {
        0% { opacity: 0.2; transform: scale(0.95); }
        50% { opacity: 0.6; transform: scale(1.05); }
        100% { opacity: 0.2; transform: scale(0.95); }
    }

    .logo.animate {
        animation: float 4s ease-in-out infinite;
    }

    .logo-glow.animate {
        animation: glow-pulse 4s ease-in-out infinite;
    }

    .welcome-heading {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        z-index: 1;
    }

    .cards-container {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 1200px;
        width: 100%;
        padding: 10px 0;
        position: relative;
        z-index: 1;
    }

    .cards-container::-webkit-scrollbar { display: none; }

    .card-link {
        flex: 0 0 240px;
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        color: var(--text);
        border-radius: 12px;
        padding: 22px 18px;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .card-link:hover {
        transform: translateY(-8px);
        background: var(--hover-gradient);
        box-shadow: 0 12px 24px rgba(0,0,0,0.4);
    }

    .card-link::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .card-link:hover::after {
        transform: translateX(50%);
    }

    .card-icon {
        display: block;
        font-size: 1.8rem;
        margin-bottom: 12px;
        color: var(--accent);
        transition: transform 0.3s ease;
    }

    .card-link:hover .card-icon {
        transform: scale(1.2);
    }

    .card-link h2 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-link p {
        font-size: 0.95rem;
        color: #ddd;
        margin: 0;
    }

    .bottom-title {
        font-size: 1rem;
        font-weight: 500;
        color: #aaa;
        margin-top: 2.5rem;
        text-align: center;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .divider {
        width: 40px;
        height: 2px;
        background: var(--gradient);
        display: inline-block;
    }

    @media (max-width: 768px) {
        .cards-container {
            gap: 15px;
            overflow-x: auto;
            flex-wrap: nowrap;
            justify-content: flex-start;
            padding-bottom: 15px;
            margin-bottom: 10px;
        }

        .card-link {
            flex: 0 0 220px;
        }
    }
</style>

<div class="welcome-screen">
    <div class="particles-container" id="particles"></div>

    <div class="logo-container">
        <div class="logo-glow"></div>
        <img src="{{ asset('assests/logo.png') }}" alt="Logo Centre" class="logo">
    </div>

    <h1 class="welcome-heading">Bienvenue au Centre de Langues</h1>
    
    @php
        use Illuminate\Support\Facades\Auth;
    @endphp
    
    @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="alert alert-info mb-4" style="max-width: 800px; background-color: rgba(51, 148, 205, 0.18); border: 1px solid rgba(51, 148, 205, 0.3); color: #f0f0f0;">
        <h5 class="alert-heading"><i class="fas fa-shield-alt me-2"></i>Information Administrateur</h5>
        <p>En tant qu'administrateur, vous avez accès à toutes les fonctionnalités de gestion, y compris :</p>
        <ul>
            <li>Création et gestion des comptes utilisateurs</li>
            <li>Modification des services et actualités</li>
            <li>Gestion complète des données</li>
        </ul>
        <p class="mb-0">Les utilisateurs standards ne peuvent pas créer de comptes ni modifier les données.</p>
    </div>
    @endif

    <div class="cards-container">
        <a href="{{ route('public') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-tv"></i></span>
                <h2>Écran Public</h2>
                <p>Voir le slideshow en direct.</p>
            </div>
        </a>

        <a href="{{ route('services.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-book-reader"></i></span>
                <h2>Services</h2>
                <p>Ajoutez les services à afficher.</p>
            </div>
        </a>

        <a href="{{ route('news.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-newspaper"></i></span>
                <h2>Nouveautés</h2>
                <p>Ajoutez les nouveautés.</p>
            </div>
        </a>
        
        @auth
        <a href="{{ route('eleves.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-user-graduate"></i></span>
                <h2>Élèves</h2>
                <p>Gérez les élèves du centre.</p>
            </div>
        </a>
        
        <a href="{{ route('formateurs.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <h2>Formateurs</h2>
                <p>Gérez les formateurs.</p>
            </div>
        </a>
        
        <a href="{{ route('formations.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-graduation-cap"></i></span>
                <h2>Formations</h2>
                <p>Gérez les formations et niveaux.</p>
            </div>
        </a>
        
        <a href="{{ route('paiements.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-money-bill-wave"></i></span>
                <h2>Paiements</h2>
                <p>Suivi des paiements des élèves.</p>
            </div>
        </a>
        
        <a href="{{ route('salles.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-door-open"></i></span>
                <h2>Salles</h2>
                <p>Gérez les salles de cours.</p>
            </div>
        </a>
        
        <a href="{{ route('emploi-du-temps.index') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-calendar-alt"></i></span>
                <h2>Emploi du temps</h2>
                <p>Consultez l'emploi du temps.</p>
            </div>
        </a>
        
        <a href="{{ route('profile.show') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-user-circle"></i></span>
                <h2>Mon Compte</h2>
                <p>Gérez votre profil.</p>
            </div>
        </a>
        @else
        <a href="{{ route('login') }}" class="card-link">
            <div class="d-flex flex-column align-items-center text-center">
                <span class="card-icon"><i class="fas fa-lock"></i></span>
                <h2>Connexion</h2>
                <p>Accédez à votre espace.</p>
            </div>
        </a>
        @endauth
    </div>

    <div class="bottom-title">
        <span class="divider"></span>
        Centre de Langues – Apprenez et progressez avec nous !
        <span class="divider"></span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logo = document.querySelector(".logo");
    const logoGlow = document.querySelector(".logo-glow");

    if (logo && logoGlow) {
        logo.classList.add("animate");
        logoGlow.classList.add("animate");

        logo.addEventListener("mouseenter", () => {
            logo.style.transform = "scale(1.1) rotate(3deg)";
        });

        logo.addEventListener("mouseleave", () => {
            logo.style.transform = "";
        });
    }

    createParticles();
});

function createParticles() {
    const container = document.getElementById("particles");
    const particleCount = 20;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement("div");
        particle.classList.add("particle");

        const size = Math.random() * 11 + 4;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        particle.style.opacity = Math.random() * 0.5 + 0.1;

        const duration = Math.random() * 30 + 15;
        const directionX = Math.random() > 0.5 ? 1 : -1;
        const directionY = Math.random() > 0.5 ? 1 : -1;
        const transformX = Math.random() * 100 * directionX;
        const transformY = Math.random() * 100 * directionY;

        const styleSheet = document.styleSheets[0];
        const animationName = `move-${i}`;
        styleSheet.insertRule(`
            @keyframes ${animationName} {
                0% { transform: translate(0, 0); }
                100% { transform: translate(${transformX}px, ${transformY}px); }
            }
        `, styleSheet.cssRules.length);

        particle.style.animation = `${animationName} ${duration}s linear infinite alternate`;
        particle.style.animationDelay = `-${Math.random() * duration}s`;

        container.appendChild(particle);
    }
}
</script>
@endsection
