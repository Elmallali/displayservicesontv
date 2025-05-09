<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('{{ asset("assests/bg.jpg") }}') no-repeat center center;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #f0f0f0;
    }

    /* légère superposition sombre pour améliorer la lisibilité */
    .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 0;
    }

    .welcome-screen {
      position: relative;
      z-index: 1;
      text-align: center;
      width: 100%;
      max-width: 1000px;
      padding: 30px;
    }

    .logo {
      height: 120px;            /* logo plus grand */
      margin-bottom: 50px;
    }

    .cards-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      margin-bottom: 60px;       
    }

    .card-link {
      background: #2e2e2e;       /* gris anthracite */
      color: #fff;
      border: none;
      border-radius: 16px;
      padding: 50px 30px;
      text-decoration: none;
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
      box-shadow: 0 6px 20px rgba(0,0,0,0.5);
    }

    .card-link:hover {
      transform: translateY(-10px);
      background: #0044cc;       /* accent bleu */
      box-shadow: 0 10px 30px rgba(0,68,204,0.7);
    }

    .card-link h2 {
      font-size: 1.75rem;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .card-link p {
      margin-bottom: 0;
      font-size: 1.1rem;
      color: #ddd;
    }

    .bottom-title {
      font-size: 1.3rem;
      font-weight: 500;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="welcome-screen">

    {{-- Logo centré --}}
    <img src="{{ asset('assests/logo.png') }}" alt="Logo Centre" class="logo mx-auto d-block">

    {{-- Cartes --}}
    <div class="cards-container">
      <a href="{{ route('public') }}" class="card-link">
        <h2>🎬 Écran Public</h2>
        <p>Découvrez nos services en direct.</p>
      </a>

      <a href="{{ route('login') }}" class="card-link">
        <h2>🔐 Connexion</h2>
        <p>Accédez à votre espace.</p>
      </a>

      <a href="{{ route('register') }}" class="card-link">
        <h2>📝 Inscription</h2>
        <p>Rejoignez-nous dès maintenant.</p>
      </a>
    </div>

    {{-- Titre en bas --}}
    <div class="bottom-title">
      Centre de Langues – Apprenez et progressez avec nous !
    </div>

  </div>
</body>
</html>
