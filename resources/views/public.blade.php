@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Add weather icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
<style>
  body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: black;
      color: white;
      overflow: hidden;
  }

  /* Header */
  .smart-header {
      background-color: #0A1931;
      color: white;
      height: 100px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
  }

  .header-left {
      display: flex;
      flex-direction: column;
      align-items: center;
  }

  .logo-big {
      height: 65px;
  }

  #live-time {
      font-size: 1.50rem;
      margin-top: 5px;
  }

  .header-right {
      font-size: 1.1rem;
      font-weight: 600;
      text-align: right;
      max-width: 60%;
  }

  .typewriter {
      border-right: 2px solid #fff;
      white-space: nowrap;
      overflow: visible;
      width: fit-content;
      margin-left: auto;
      margin-right: 0;
      font-weight: bold;
      font-size: 1.5rem;
      max-width: 100%;
  }

  /* Slides */
  .public-screen {
      height: 100vh;
      width: 100vw;
      position: relative;
      padding-top: 100px; /* Ajusté à la hauteur du header */
      box-sizing: border-box;
  }

  .slide {
      position: absolute;
      inset: 0;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0;
      transition: opacity 1s ease-in-out;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      z-index: 0;
      padding: 3rem 1rem;
      text-align: center;
  }

  .slide.active {
      opacity: 1;
      z-index: 1;
  }

  .slide h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #fff;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.7);
  }

  .slide p {
      font-size: 1.3rem;
      max-width: 85%;
      color: #f3f3f3;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
      line-height: 1.6;
  }

  .dots-fixed {
      position: fixed;
      bottom: 70px;
      width: 100%;
      display: flex;
      justify-content: center;
      gap: 8px;
      z-index: 10;
  }

  .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #fff;
      opacity: 0.4;
      cursor: pointer;
      transition: 0.3s;
  }

  .dot.active {
      opacity: 1;
      background: #f1f1f1;
  }

  /* Footer */
  .footer-fixed {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color:#0A1931;
      color: white;
      font-weight: 600;
      display: flex;
      align-items: center;
      padding: 10px 30px;
      font-size: 1.05rem;
      z-index: 999;
      gap: 30px;
  }

  .footer-left {
      flex: 0 0 auto;
      text-align: left;
      white-space: nowrap;
  }

  .footer-center {
      flex: 1 1 auto;
      overflow: hidden;
      white-space: nowrap;
      text-align: center;
  }

  .footer-right {
      flex: 0 0 auto;
      text-align: right;
      white-space: nowrap;
  }

  .scrolling-news {
      overflow: hidden;
      white-space: nowrap;
      width: 100%;
  }

  .scrolling-track {
      display: inline-block;
      padding-left: 100%;
      animation: scrollLoop 60s linear infinite;
  }

  .news-item {
      display: inline-block;
      margin: 0 60px;
      font-size: 1rem;
      white-space: nowrap;
  }

  @keyframes scrollLoop {
      0%   { transform: translateX(0%); }
      100% { transform: translateX(-50%); }
  }

  .animated-welcome {
      font-size: 1.9rem;
      font-weight: 700;
      height: 40px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      color: white;
      padding-right: 30px;
  }

  .fade-slide {
      display: inline-block;
      opacity: 0;
      transform: translateY(20px) scale(0.98);
      transition: all 0.8s ease;
  }
  .fade-slide.show {
      opacity: 1;
      transform: translateY(0) scale(1);
  }
  @keyframes logoPulse {
      0% { transform: scale(1) rotate(0deg); }
      50% { transform: scale(1.1) rotate(5deg); }
      100% { transform: scale(1) rotate(0deg); }
  }
  .logo-animated {
      transition: transform 0.5s ease;
  }
  .logo-animated.animate {
      animation: logoPulse 1s ease;
  }

  .promo-overlay {
      position: fixed;
      inset: 0;
      background: #0A1931;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      z-index: 2000;
      text-align: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 1s ease;
  }

  .promo-overlay.active {
      opacity: 1;
      pointer-events: all;
  }

  .promo-logo {
      height: 100px;
      margin-bottom: 1rem;
  }

  .promo-slogan {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
  }

  .promo-contact {
      font-size: 1rem;
      opacity: 0.8;
  }
  .scrolling-logo {
      height: 30px;
      margin-bottom: 0.5rem;
      margin-left: 5rem;
      flex-shrink: 0;
  }
  .time-header {
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: #0A1931; 
      padding: 5px 12px;
      color: white;
      font-family: 'Poppins', sans-serif;
  }

  .logo-block {
      display: flex;
      align-items: center;
  }

  .logo-img {
      height: 40px;
  }

  .divider {
      width: 1px;
      height: 30px;
      background-color: rgba(255,255,255,0.6);
      margin: 0 5px;
  }

  .clock-container {
      display: flex;
      align-items: center;
      padding: 3px 8px;
  }

  .clock-text {
      font-size: 1.2rem;
      font-weight: 600;
  }

  /* Weather Widget */
  .weather-container {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-left: 5px;
      padding: 3px 8px;
  }

  .weather-icon {
      font-size: 1.8rem;
      color: #FFD700;
  }

  .weather-info {
      display: flex;
      flex-direction: column;
  }

  .temp {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0;
  }

  .city {
      font-size: 0.8rem;
      opacity: 0.9;
  }

  .details {
      font-size: 0.7rem;
      opacity: 0.8;
  }
</style>

{{-- ✅ HEADER --}}
<div class="smart-header">
    <div class="header-left">
        <div class="time-header">
            <div class="logo-block">
                <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="logo-img">
            </div>
          
            <div class="divider"></div>
          
            <div class="clock-container">
                <span id="time" class="clock-text">--:--:--</span>
            </div>

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

{{-- ✅ SLIDES --}}
<div class="public-screen">
    @foreach($services as $index => $service)
        <div class="slide {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url('{{ asset('storage/' . $service->image) }}');">
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->description }}</p>
        </div>
    @endforeach
</div>

{{-- ✅ DOTS --}}
<div class="dots-fixed">
    @foreach($services as $index => $service)
        <div class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
    @endforeach
</div>

{{-- ✅ FOOTER --}}
@php
    use App\Models\News;
    $newsList = News::where('active', true)->latest()->take(6)->get();
@endphp

<div class="footer-fixed">
    <div class="footer-left">🌐 Ecole NIZAR'S de Langues</div>
    <div class="footer-center">
        <div class="scrolling-news">
            <div class="scrolling-track">
                @foreach ($newsList as $item)
                    <span class="news-item"> {{ $item->texte }} <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="scrolling-logo"></span>
                @endforeach
                @foreach ($newsList as $item)
                    <span class="news-item"> {{ $item->texte }} <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="scrolling-logo"></span>
                @endforeach
            </div>
        </div>
    </div>
    

    <div class="footer-right">
        {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} |
        {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('dddd D MMMM YYYY') }}
    </div>
</div>

{{-- ✅ SCRIPTS --}}
<script>
    // Slides
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
            dots[i].classList.toggle('active', i === index);
        });
    }

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 15000);

    // Clock
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('time').textContent = timeStr;
    }

    updateTime();
    setInterval(updateTime, 1000);

    // Typewriter Effect
    const messages = [
        // Original provided phrases
        "🎓 Ecole de langues NIZAR`S vous souhaite la bienvenue", // French
        "🎓 مدرسة نزار للغات ترحب بكم"   , // Arabic
        "🎓 Welcome to NIZAR Language School", // English
        "🎓 Escuela de Idiomas NIZAR les da la bienvenida", // Spanish
        "🎓 Taalschool NIZAR heet u welkom", // Dutch
        "🎓 Языковая школа NIZAR приветствует вас" // Russian
    ];
    let index = 0;
    const messageEl = document.getElementById("welcome-message");

    function rotateMessage() {
        // hide current
        messageEl.classList.remove("show");

        setTimeout(() => {
            messageEl.textContent = messages[index];
            messageEl.classList.add("show");
            index = (index + 1) % messages.length;
        }, 400); // time for fade-out
    }

    // Start
    rotateMessage();
    setInterval(rotateMessage, 5000); // every 4.5 seconds
    
    // Promotional overlay
    const promo = document.getElementById('promoOverlay');

    function showPromo() {
        promo.classList.add('active');

        setTimeout(() => {
            promo.classList.remove('active');
        }, 10000); // show for 10 seconds
    }

    // Show promo every 5 minutes
    setInterval(() => {
        showPromo();
    }, 60*5*1000);

    // Weather API integration
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
            // Replace with your OpenWeatherMap API key and desired city
            const apiKey = 'ee2c2c84cf69740566d02ddaedb5ac58';
            const city = 'taza'; // Change to your city
            const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=fr`;
            
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.cod === 200) {
                // Update DOM elements
                document.getElementById('weather-temp').textContent = `${Math.round(data.main.temp)}°C`;
                document.getElementById('weather-city').textContent = data.name;
                document.getElementById('weather-details').textContent = `${data.weather[0].description} | ${data.main.humidity}% d'humidité`;
                
                // Update weather icon
                const weatherCondition = data.weather[0].main;
                const iconClass = weatherIcons[weatherCondition] || weatherIcons['default'];
                document.getElementById('weather-icon').className = `wi ${iconClass} weather-icon`;
            } else {
                console.error('Error fetching weather data:', data.message);
            }
        } catch (error) {
            console.error('Error fetching weather data:', error);
        }
    }

    // Get weather data initially
    getWeatherData();
    
    // Update weather every 30 minutes
    setInterval(getWeatherData, 30 * 60 * 1000);

    // Optional: animate logo if the logo variable exists
    const logo = document.querySelector(".logo-img");
    if (logo) {
        function animateLogo() {
            logo.classList.add("animate");
            setTimeout(() => {
                logo.classList.remove("animate");
            }, 3000);
        }

        setInterval(animateLogo, 5000);
    }
</script>
@endsection