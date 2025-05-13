@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

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
        height: 120px;
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
        flex-direction: column;
        align-items: center;
    }

    .logo-big {
        height: 65px;
    }

    #live-time {
        font-size: 0.85rem;
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
        max-width: 100%;   /* أو 60% حسب المساحة المتاحة */

    }

    /* Slides */
    .public-screen {
    height: 100vh;
    width: 100vw;
    position: relative;
    padding-top: 120px; /* لتفادي تغطية الهيدر للمحتوى */
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
        display: inline-block;
        animation: scrollNews 20s linear infinite;
    }

    .news-item {
        margin: 0 30px;
        font-size: 0.95rem;
    }

    @keyframes scrollNews {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
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



</style>

{{-- ✅ HEADER --}}
<div class="smart-header">
    <div class="header-left">
        <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="logo-big logo-animated" id="logo">
        <div id="live-time">--:--</div>
    </div>

    <div class="animated-welcome">
        <span id="welcome-message" class="fade-slide"></span>
      </div>
      
</div>

<div class="promo-overlay" id="promoOverlay">
    <div class="promo-content">
      <img src="{{ asset('assests/logo.png') }}" alt="Logo" class="promo-logo">
      <h2 class="promo-slogan">📚 Centre de Langues NIZAR – Apprenez aujourd’hui, parlez demain</h2>
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
    $newsList = News::where('active', true)->latest()->take(10)->get();
@endphp

<div class="footer-fixed">
    <div class="footer-left">🌐 Ecole NIZAR'S de Langues</div>

    <div class="footer-center">
        <div class="scrolling-news">
            @foreach ($newsList as $item)
                <span class="news-item">📢 {{ $item->texte }}</span>
            @endforeach
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
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('live-time').textContent = time;
    }
    updateClock();
    setInterval(updateClock, 1000);

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
  const logo = document.getElementById("logo");

function animateLogo() {
  logo.classList.add("animate");
  setTimeout(() => {
    logo.classList.remove("animate");
  }, 3000);
}

setInterval(animateLogo, 5000); // كل 20 ثانية

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
  },10000);

  // Optional: show it once 15 seconds after load to test
  // setTimeout(showPromo, 15000);

  </script>
@endsection
