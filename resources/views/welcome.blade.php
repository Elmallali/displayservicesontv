<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Centre de Langues - Bienvenue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #3563E9;
      --secondary: #121A2D;
      --accent: #4FBAEE;
      --text: #F6F7FB;
      --background: #0E1629;
      --card-bg: rgba(69, 95, 161, 0.15);
      --gradient: linear-gradient(135deg, #3563E9, #4FBAEE);
    }
    
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
      background-color: var(--background);
      color: var(--text);
      overflow-x: hidden;
    }
    
    .particles-container {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0;
      overflow: hidden;
    }
    
    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      pointer-events: none;
      opacity: 0.4;
    }
    
    /* Header style */
    .header {
      padding: 1.5rem 0;
      position: relative;
      z-index: 1;
    }
    
    /* Logo container and animation */
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      height: 280px;
      margin-bottom: 3rem;
      overflow: visible;
    }
    
    .logo {
      max-height: 220px;
      width: auto;
      object-fit: contain;
      border-radius: 12px;
      filter: drop-shadow(0 10px 15px rgba(53, 99, 233, 0.3));
      background-color: rgba(246, 247, 251, 0.95);
      padding: 1rem;
      box-shadow: 0 0 0 rgba(79, 186, 238, 0.4);
      position: relative;
      z-index: 2;
      transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .logo-glow {
      position: absolute;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(79, 186, 238, 0.6) 0%, rgba(53, 99, 233, 0) 70%);
      filter: blur(20px);
      opacity: 0;
      transition: opacity 1s ease;
      z-index: 1;
      pointer-events: none;
    }
    
    /* Define floating animation */
    @keyframes floating {
      0% {
        transform: translateY(0px) rotate(0deg);
      }
      50% {
        transform: translateY(-15px) rotate(2deg);
      }
      100% {
        transform: translateY(0px) rotate(0deg);
      }
    }
    
    /* Define pulse glow animation */
    @keyframes pulse-glow {
      0% {
        opacity: 0.2;
        transform: scale(0.95);
      }
      50% {
        opacity: 0.8;
        transform: scale(1.05);
      }
      100% {
        opacity: 0.2;
        transform: scale(0.95);
      }
    }
    
    .logo.animate {
      animation: floating 4s ease-in-out infinite;
    }
    
    .logo-glow.animate {
      animation: pulse-glow 4s ease-in-out infinite;
    }
    
    /* Main content container */
    .welcome-screen {
      text-align: center;
      max-width: 1200px;
      padding: 0 30px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }
    
    /* Welcome heading */
    .welcome-heading {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: -0.5px;
    }
    
    /* Cards container */
    .cards-container {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin: 2.5rem 0;
    }
    
    /* Card link style */
    .card-link {
      flex: 0 1 280px;
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      color: var(--text);
      border-radius: 16px;
      padding: 30px 25px;
      text-decoration: none;
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
      overflow: hidden;
    }
    
    /* Card hover effects */
    .card-link:hover {
      transform: translateY(-10px);
      background: var(--gradient);
      box-shadow: 0 15px 30px rgba(53, 99, 233, 0.3);
      border-color: var(--accent);
    }
    
    .card-link::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    
    .card-link:hover::after {
      opacity: 1;
    }
    
    /* Card icon */
    .card-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
      display: block;
      color: var(--accent);
      transition: transform 0.3s ease;
    }
    
    .card-link:hover .card-icon {
      transform: scale(1.2);
      color: var(--text);
    }
    
    /* Card heading */
    .card-link h2 {
      font-size: 1.4rem;
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    /* Card paragraph */
    .card-link p {
      margin: 0;
      font-size: 0.95rem;
      color: rgba(246, 247, 251, 0.8);
      line-height: 1.5;
    }
    
    /* Bottom title */
    .bottom-title {
      font-size: 1.1rem;
      font-weight: 500;
      color: var(--accent);
      margin-top: 3rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    .divider {
      width: 50px;
      height: 2px;
      background: var(--gradient);
      display: inline-block;
    }
    
    /* Footer */
    .footer {
      padding: 1.5rem 0;
      text-align: center;
      font-size: 0.9rem;
      color: rgba(246, 247, 251, 0.6);
      margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
      .welcome-heading {
        font-size: 2rem;
      }
      
      .logo {
        max-height: 180px;
      }
      
      .card-link {
        flex: 0 1 100%;
      }
    }
  </style>
</head>
<body>
  <!-- Particles background -->
  <div class="particles-container" id="particles-js"></div>
  
  <div class="welcome-screen">
    <div class="header">
      <!-- Logo with animation -->
      <div class="logo-container">
        <div class="logo-glow"></div>
        <img src="{{ asset('assests/logo.png') }}" alt="Centre de Langues" class="logo">
      </div>
      
      <h1 class="welcome-heading">Bienvenue au Centre de Langues</h1>
      <p class="lead">Votre porte d'entrée vers un monde de possibilités linguistiques</p>
    </div>
    
    <!-- Service cards -->
    <div class="cards-container">
      <a href="{{ route('public') }}" class="card-link">
        <span class="card-icon"><i class="fas fa-tv"></i></span>
        <h2>Écran Public</h2>
        <p>Consultez notre affichage dynamique et découvrez nos services en temps réel.</p>
      </a>
      
      {{-- <a href="{{ route('services.index') }}" class="card-link">
        <span class="card-icon"><i class="fas fa-book-open"></i></span>
        <h2>Nos Services</h2>
        <p>Explorez notre gamme complète de services linguistiques disponibles.</p>
      </a> --}}
      
      <a href="{{ route('login') }}" class="card-link">
        <span class="card-icon"><i class="fas fa-user-circle"></i></span>
        <h2>Espace Personnel</h2>
        <p>Connectez-vous à votre compte pour accéder à votre espace personnel.</p>
      </a>
    </div>
    
    <!-- Bottom slogan -->
    <div class="bottom-title">
      <span class="divider"></span>
      Centre de Langues – Apprenez et progressez avec nous !
      <span class="divider"></span>
    </div>
  </div>
  
  <footer class="footer">
    <p>&copy; 2025 Centre de Langues NIZAR`S. Tous droits réservés.</p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Create particles
      createParticles();
      
      // Logo animation
      const logo = document.querySelector(".logo");
      const logoGlow = document.querySelector(".logo-glow");
      
      // Start animations immediately
      if (logo && logoGlow) {
        logo.classList.add("animate");
        logoGlow.classList.add("animate");
        
        // Add hover effect on logo
        logo.addEventListener("mouseenter", function() {
          logo.style.transform = "scale(1.05) rotate(5deg)";
        });
        
        logo.addEventListener("mouseleave", function() {
          logo.style.transform = "";
        });
      }
    });
    
    // Create floating particles in the background
    function createParticles() {
      const container = document.querySelector(".particles-container");
      const particleCount = 30;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement("div");
        particle.classList.add("particle");
        
        // Random size between 5 and 20px
        const size = Math.random() * 15 + 5;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Random position
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        
        // Subtle blue tint
        const blueOpacity = Math.random() * 0.3;
        particle.style.backgroundColor = `rgba(79, 186, 238, ${blueOpacity})`;
        
        // Animation
        const duration = Math.random() * 20 + 10;
        const directionX = Math.random() > 0.5 ? 1 : -1;
        const directionY = Math.random() > 0.5 ? 1 : -1;
        const transformX = Math.random() * 100 * directionX;
        const transformY = Math.random() * 100 * directionY;
        
        particle.style.animation = `
          moveParticle ${duration}s linear infinite alternate,
          fadeInOut ${duration / 2}s ease-in-out infinite alternate
        `;
        
        particle.style.animationDelay = `-${Math.random() * duration}s`;
        
        // Add keyframes for this specific particle
        const styleSheet = document.styleSheets[0];
        styleSheet.insertRule(`
          @keyframes moveParticle {
            0% { transform: translate(0, 0); }
            100% { transform: translate(${transformX}px, ${transformY}px); }
          }
        `, styleSheet.cssRules.length);
        
        styleSheet.insertRule(`
          @keyframes fadeInOut {
            0% { opacity: 0.1; }
            100% { opacity: 0.7; }
          }
        `, styleSheet.cssRules.length);
        
        container.appendChild(particle);
      }
    }
  </script>
</body>
</html>