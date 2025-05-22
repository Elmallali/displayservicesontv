@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
<style>
  :root {
    --primary-blue: #0A1931;
    --secondary-blue: #183A5B;
    --accent-gold: #FFD700;
    --accent-red: #CF0E0E;
    --text-white: #FFFFFF;
    --text-light: #F3F3F3;
    --glass-bg: rgba(255, 255, 255, 0.1);
    --shadow-light: rgba(255, 255, 255, 0.2);
    --shadow-dark: rgba(0, 0, 0, 0.3);
    --header-height: 120px;
    --footer-height: 80px;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0A1931 0%, #183A5B 50%, #2C5F7D 100%);
    color: var(--text-white);
    overflow: hidden;
    height: 100vh;
  }

  /* Enhanced Header */
  .smart-header {
    background: linear-gradient(90deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    backdrop-filter: blur(20px);
    border-bottom: 2px solid var(--glass-bg);
    box-shadow: 0 8px 32px var(--shadow-dark);
    height: var(--header-height);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 40px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
  }

  .header-left {
    display: flex;
    align-items: center;
    gap: 20px;
  }

  .time-header {
    display: flex;
    align-items: center;
    gap: 15px;
    background: var(--glass-bg);
    backdrop-filter: blur(15px);
    padding: 10px 20px;
    border-radius: 20px;
    border: 1px solid var(--shadow-light);
    box-shadow: 0 4px 20px var(--shadow-dark);
  }

  .logo-block {
    position: relative;
  }

  .logo-img {
    height: 90px;
    background: linear-gradient(135deg, #FFFFFF 0%, #F8F9FA 100%);
    padding: 10px;
    border-radius: 15px;
    box-shadow: 0 6px 25px var(--shadow-dark);
    transition: all 0.3s ease;
  }

  .logo-img:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 35px var(--shadow-dark);
  }

  .divider {
    width: 2px;
    height: 40px;
    background: linear-gradient(to bottom, transparent, var(--accent-gold), transparent);
    border-radius: 2px;
  }

  .weather-container {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--glass-bg);
    padding: 10px 15px;
    border-radius: 15px;
    border: 1px solid var(--shadow-light);
  }

  .weather-icon {
    font-size: 2.2rem;
    color: var(--accent-gold);
    text-shadow: 0 0 10px var(--accent-gold);
    animation: gentle-glow 3s ease-in-out infinite;
  }

  @keyframes gentle-glow {
    0%, 100% { text-shadow: 0 0 10px var(--accent-gold); }
    50% { text-shadow: 0 0 20px var(--accent-gold), 0 0 30px var(--accent-gold); }
  }

  .weather-info {
    display: flex;
    flex-direction: column;
  }

  .temp {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-white);
  }

  .city {
    font-size: 0.9rem;
    font-weight: 500;
    opacity: 0.9;
    color: var(--accent-gold);
  }

  .details {
    font-size: 0.75rem;
    opacity: 0.8;
    color: var(--text-light);
  }

  /* Enhanced Welcome Message - REMOVED BORDER AND BACKGROUND */
  .animated-welcome {
    position: relative;
    padding: 15px 0; /* Removed horizontal padding and background */
  }

  .fade-slide {
    font-size: 1.8rem;
    font-weight: 600;
    background: linear-gradient(45deg, var(--text-white), var(--accent-gold));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .fade-slide.show {
    opacity: 1;
    transform: translateY(0) scale(1);
  }

  /* Enhanced Slides - OPTIMIZED FOR BIGGER IMAGE */
  .public-screen {
    height: 100vh;
    width: 100vw;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .slide {
    position: absolute;
    top: var(--header-height);
    bottom: var(--footer-height);
    left: 0;
    right: 0;
    opacity: 0;
    transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 0;
    padding: 40px;
    background: linear-gradient(135deg, 
      rgba(10, 25, 49, 0.1) 0%, 
      rgba(24, 58, 91, 0.1) 50%, 
      rgba(44, 95, 125, 0.1) 100%);
  }

  .slide.active {
    opacity: 1;
    z-index: 1;
  }

  .slide-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    max-width: 1400px;
    width: 100%;
    gap: 30px; /* Reduced gap */
    margin: 0 auto;
    padding: 20px;
  }

  /* BIGGER IMAGE - Increased flex ratio */
  .image-wrapper {
    flex: 2.2; /* Increased from 1.6 to 2.2 */
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }

  .slide-image {
    width: 100%;
    height: auto;
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 25px;
    box-shadow: 
      0 20px 60px rgba(0, 0, 0, 0.3),
      0 0 40px rgba(255, 215, 0, 0.1);
    transition: all 0.3s ease;
    border: 3px solid var(--glass-bg);
  }

  .slide-image:hover {
    transform: scale(1.02);
    box-shadow: 
      0 25px 80px rgba(0, 0, 0, 0.4),
      0 0 60px rgba(255, 215, 0, 0.2);
  }

  /* SMALLER TEXT CONTENT - Reduced flex ratio and font sizes */
  .text-content {
    flex: 0.8; /* Reduced from 0.6 to 0.8 but will appear smaller due to image being bigger */
    text-align: left;
    padding: 20px; /* Reduced from 30px */
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border-radius: 25px; /* Slightly reduced */
    border: 1px solid var(--shadow-light);
    box-shadow: 0 15px 50px var(--shadow-dark);
    position: relative;
    overflow: hidden;
    height: fit-content;
    max-height: 80%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .text-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-gold), var(--accent-red), var(--accent-gold));
    border-radius: 25px 25px 0 0;
  }

  /* SMALLER TITLE */
  .text-content h1 {
    font-size: 1.8rem; /* Reduced from 2.2rem */
    font-weight: 700;
    margin-bottom: 15px; /* Reduced from 20px */
    background: linear-gradient(135deg, var(--text-white), var(--accent-gold));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.2;
  }

  /* SMALLER DESCRIPTION */
  .text-content p {
    font-size: 0.95rem; /* Reduced from 1.1rem */
    font-weight: 400;
    line-height: 1.5; /* Slightly reduced */
    color: var(--text-light);
    text-align: justify;
    margin: 0;
  }

  /* Enhanced Footer */
  .footer-fixed {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: var(--footer-height);
    background: linear-gradient(90deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    backdrop-filter: blur(20px);
    border-top: 2px solid var(--glass-bg);
    box-shadow: 0 -8px 32px var(--shadow-dark);
    color: var(--text-white);
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 15px 40px;
    font-size: 1.1rem;
    z-index: 999;
    gap: 30px;
  }

  .footer-left {
    flex: 0 0 auto;
    font-weight: 600;
    color: var(--accent-gold);
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .footer-left::before {
    content: '';
    font-size: 1.2rem;
  }

  .footer-center {
    flex: 1 1 auto;
    overflow: hidden;
    white-space: nowrap;
    text-align: center;
    padding: 10px 20px;
    background: var(--glass-bg);
    border-radius: 15px;
    border: 1px solid var(--shadow-light);
    position: relative;
  }

  .footer-center::before,
  .footer-center::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--accent-red), var(--accent-gold));
  }

  .footer-center::before { left: 0; }
  .footer-center::after { right: 0; }

  .scrolling-news {
    overflow: hidden;
    white-space: nowrap;
    width: 100%;
  }

  .scrolling-track {
    display: inline-block;
    padding-left: 100%;
    animation: scrollLoop 80s linear infinite;
  }

  .news-item {
    display: inline-block;
    margin: 0 80px;
    font-size: 1rem;
    font-weight: 500;
    white-space: nowrap;
    color: var(--text-light);
  }

  @keyframes scrollLoop {
    0%   { transform: translateX(0%); }
    100% { transform: translateX(-50%); }
  }

  .scrolling-logo {
    height: 35px;
    margin: 0 10px;
    background: var(--glass-bg);
    padding: 6px;
    border-radius: 10px;
    vertical-align: middle;
    transition: all 0.3s ease;
  }

  /* BIGGER CLOCK */
  .footer-right {
    flex: 0 0 auto;
    text-align: right;
    background: var(--glass-bg);
    padding: 1px 25px; /* Increased padding */
    border-radius: 15px;
    border: 1px solid var(--shadow-light);
  }

  .date-time-box {
    font-size: 1.2rem; /* Increased from 1.1rem */
    font-weight: 600;
    color: var(--text-white);
  }

  #time {
    font-family: 'Courier New', monospace;
    color: var(--accent-gold);
    font-weight: 700;
    font-size: 1.4rem; /* Added specific larger size for time */
  }

  /* Enhanced Promo Overlay */
  .promo-overlay {
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, 
      rgba(10, 25, 49, 0.95) 0%, 
      rgba(24, 58, 91, 0.95) 50%, 
      rgba(44, 95, 125, 0.95) 100%);
    backdrop-filter: blur(30px);
    color: var(--text-white);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    z-index: 2000;
    text-align: center;
    opacity: 0;
    pointer-events: none;
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .promo-overlay.active {
    opacity: 1;
    pointer-events: all;
  }

  .promo-content {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    padding: 60px;
    border-radius: 30px;
    border: 2px solid var(--shadow-light);
    box-shadow: 0 25px 80px var(--shadow-dark);
    max-width: 800px;
    transform: scale(0.9);
    transition: all 0.5s ease;
  }

  .promo-overlay.active .promo-content {
    transform: scale(1);
  }

  .promo-logo {
    height: 120px;
    margin-bottom: 30px;
    background: var(--text-white);
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 40px var(--shadow-dark);
  }

  .promo-slogan {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(135deg, var(--text-white), var(--accent-gold));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.4;
  }

  .promo-contact {
    font-size: 1.2rem;
    font-weight: 500;
    color: var(--text-light);
    opacity: 0.9;
  }

  /* Animations */
  @keyframes logoPulse {
    0% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.05) rotate(2deg); }
    100% { transform: scale(1) rotate(0deg); }
  }

  .logo-animated.animate {
    animation: logoPulse 2s ease-in-out;
  }

  /* Responsive Design */
  @media (max-width: 1200px) {
    .slide-content {
      gap: 25px;
      padding: 15px;
    }
    
    .text-content h1 {
      font-size: 1.6rem;
    }
    
    .text-content p {
      font-size: 0.9rem;
    }
  }

  @media (max-width: 768px) {
    .slide-content {
      flex-direction: column;
      gap: 20px;
    }
    
    .image-wrapper,
    .text-content {
      flex: none;
      width: 100%;
    }
    
    .image-wrapper {
      height: 50%;
    }
    
    .text-content {
      padding: 20px;
      height: auto;
      max-height: 45%;
    }
    
    .text-content h1 {
      font-size: 1.5rem;
    }
    
    .text-content p {
      font-size: 0.85rem;
    }
    
    .smart-header {
      padding: 0 20px;
      height: 100px;
    }
    
    .footer-fixed {
      padding: 10px 20px;
      font-size: 1rem;
      height: 70px;
    }
    
    :root {
      --header-height: 100px;
      --footer-height: 70px;
    }
  }

  /* Accessibility */
  @media (prefers-reduced-motion: reduce) {
    * {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
  }
</style>

{{-- ✅ ENHANCED HEADER --}}
<div class="smart-header">
    <div class="header-left">
        <div class="time-header">
            <div class="logo-block">
                <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="logo-img logo-animated">
            </div>
          
            <div class="divider"></div>

            <div class="weather-container">
                <i id="weather-icon" class="wi wi-day-sunny weather-icon"></i>
                <div class="weather-info">
                    <div class="temp" id="weather-temp">--°C</div>
                    <div class="city" id="weather-city">Chargement...</div>
                    <div class="details" id="weather-details">--</div>
                </div>
            </div>
        </div>
    </div>

    <div class="animated-welcome">
        <span id="welcome-message" class="fade-slide"></span>
    </div>
</div>

<div class="promo-overlay" id="promoOverlay">
    <div class="promo-content">
        <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="promo-logo">
        <h2 class="promo-slogan">📚 Centre de Langues NIZAR – Apprenez aujourd'hui, parlez demain</h2>
        <p class="promo-contact">☎ 06 00 00 00 00 — ✉ contact@centre-nizar.ma</p>
    </div>
</div>

{{-- ✅ ENHANCED SLIDES --}}
<div class="public-screen">
    @foreach($services as $index => $service)
      <div class="slide {{ $index === 0 ? 'active' : '' }}">
        <div class="slide-content">
          <div class="image-wrapper">
            <img src="{{ asset('storage/' . $service->image) }}" alt="Image" class="slide-image">
          </div>
          <div class="text-content">
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->description }}</p>
          </div>
        </div>
      </div>
    @endforeach
</div>

{{-- ✅ ENHANCED FOOTER --}}
@php
    use App\Models\News;
    $newsList = News::where('active', true)->latest()->take(6)->get();
@endphp

<div class="footer-fixed">
    <div class="footer-left">Ecole NIZAR'S de Langues</div>
    <div class="footer-center">
        <div class="scrolling-news">
            <div class="scrolling-track">
                @foreach ($newsList as $item)
                    <span class="news-item">{{ $item->texte }} <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="scrolling-logo"></span>
                @endforeach
                @foreach ($newsList as $item)
                    <span class="news-item">{{ $item->texte }} <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="scrolling-logo"></span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="footer-right">
        <div class="date-time-box">
            <div>{{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
            <div id="time"></div>
        </div>
    </div>
</div>

{{-- ✅ ENHANCED SCRIPTS --}}
<script>
    // Enhanced Slides with smooth transitions
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    // Auto-advance slides
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 15000);

    // Enhanced Clock with smooth updates
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const timeElement = document.getElementById('time');
        if (timeElement.textContent !== timeStr) {
            timeElement.style.transform = 'scale(1.05)';
            setTimeout(() => {
                timeElement.textContent = timeStr;
                timeElement.style.transform = 'scale(1)';
            }, 100);
        }
    }

    updateTime();
    setInterval(updateTime, 1000);

    // Enhanced Typewriter Effect with better transitions
    const messages = [
        "🎓 École de langues NIZAR'S vous souhaite la bienvenue",
        "🎓 مدرسة نزار للغات ترحب بكم",
        "🎓 Welcome to NIZAR Language School",
        "🎓 Escuela de Idiomas NIZAR les da la bienvenida",
        "🎓 Taalschool NIZAR heet u welkom",
        "🎓 Языковая школа NIZAR приветствует вас"
    ];
    let messageIndex = 0;
    const messageEl = document.getElementById("welcome-message");

    function rotateMessage() {
        messageEl.classList.remove("show");

        setTimeout(() => {
            messageEl.textContent = messages[messageIndex];
            messageEl.classList.add("show");
            messageIndex = (messageIndex + 1) % messages.length;
        }, 400);
    }

    rotateMessage();
    setInterval(rotateMessage, 5000);
    
    // Enhanced Promotional overlay with better timing
    const promo = document.getElementById('promoOverlay');

    function showPromo() {
        promo.classList.add('active');
        setTimeout(() => {
            promo.classList.remove('active');
        }, 12000);
    }

    // Show promo every 5 minutes after initial delay
    setTimeout(() => {
        setInterval(showPromo, 5 * 60 * 1000);
    }, 30000);

    // Enhanced Weather API with better error handling
    const weatherIcons = {
        'Clear': 'wi-day-sunny',
        'Clouds': 'wi-cloud',
        'Rain': 'wi-rain',
        'Drizzle': 'wi-showers',
        'Thunderstorm': 'wi-thunderstorm',
        'Snow': 'wi-snow',
        'Mist': 'wi-fog',
        'Fog': 'wi-fog',
        'Haze': 'wi-day-haze',
        'Dust': 'wi-dust',
        'Smoke': 'wi-smoke',
        'default': 'wi-day-cloudy'
    };

    async function getWeatherData() {
        try {
            const apiKey = 'ee2c2c84cf69740566d02ddaedb5ac58';
            const city = 'taza';
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=fr`;
            
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.cod === 200) {
                document.getElementById('weather-temp').textContent = `${Math.round(data.main.temp)}°C`;
                document.getElementById('weather-city').textContent = data.name;
                document.getElementById('weather-details').textContent = `${data.weather[0].description} | ${data.main.humidity}% d'humidité`;
                
                const weatherCondition = data.weather[0].main;
                const iconClass = weatherIcons[weatherCondition] || weatherIcons['default'];
                document.getElementById('weather-icon').className = `wi ${iconClass} weather-icon`;
            } else {
                console.error('Error fetching weather data:', data.message);
                // Fallback display
                document.getElementById('weather-city').textContent = 'Taza';
                document.getElementById('weather-temp').textContent = '--°C';
                document.getElementById('weather-details').textContent = 'Données météo indisponibles';
            }
        } catch (error) {
            console.error('Error fetching weather data:', error);
            // Fallback display
            document.getElementById('weather-city').textContent = 'Taza';
            document.getElementById('weather-temp').textContent = '--°C';
            document.getElementById('weather-details').textContent = 'Connexion météo échouée';
        }
    }

    // Get weather data initially and update every 30 minutes
    getWeatherData();
    setInterval(getWeatherData, 30 * 60 * 1000);

    // Enhanced logo animation
    const logo = document.querySelector(".logo-img");
    if (logo) {
        function animateLogo() {
            logo.classList.add("animate");
            setTimeout(() => {
                logo.classList.remove("animate");
            }, 2000);
        }

        // Animate logo every 10 seconds
        setInterval(animateLogo, 10000);
        
        // Initial animation after page load
        setTimeout(animateLogo, 2000);
    }

    // Add smooth scroll behavior for any internal navigation
    document.documentElement.style.scrollBehavior = 'smooth';

    // Performance optimization: Pause animations when not visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            document.body.style.animationPlayState = 'paused';
        } else {
            document.body.style.animationPlayState = 'running';
        }
    });
</script>
@endsection