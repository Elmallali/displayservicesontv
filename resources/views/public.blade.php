@extends('layouts.app')

@section('content')
<!-- Google Fonts -->
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

    .public-screen {
        height: 100vh;
        width: 100vw;
        position: relative;
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
        background: #00ccff;
    }

    .footer-fixed {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #0044cc;
        color: white;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 24px;
        z-index: 10;
        font-size: 1rem;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.4);
    }
    .footer-fixed {
    justify-content: center;
    gap: 20px;
}

.footer-fixed span:first-child {
    flex: 1;
    text-align: left;
}

.footer-fixed span:last-child {
    flex: 1;
    text-align: right;
}
.header-fixed {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
    z-index: 20;
    backdrop-filter: blur(6px);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo {
    height: 40px;
    width: auto;
}

.logo-text {
    font-weight: bold;
    font-size: 1.2rem;
}

.header-right .slogan {
    font-size: 1rem;
    font-weight: 500;
    text-align: right;
    margin: 0;
    line-height: 1.4;
}

</style>

<div class="public-screen">
    @foreach($services as $index => $service)
        <div class="slide {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url('{{ asset('storage/' . $service->image) }}');">
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->description }}</p>
        </div>
    @endforeach
</div>
<div class="header-fixed">
    <div class="header-left">
        {{-- لوغو المركز أو اسمه --}}
        <img src="{{ asset('assests/logo.png') }}" alt="Centre de Langues" class="logo">
        {{-- أو ببساطة نص --}}
        {{-- <span class="logo-text">Centre de Langues</span> --}}
        <!-- {{ date("H:i") }} -->
        <div id="time">--:--</div>
    </div>
    <div class="header-right">
        <p style="padding-right: 30px;" class="slogan">Inscrivez-vous avec nous pour maîtriser les langues du monde 🌍</p>
    </div>
</div>

<div class="dots-fixed">
    @foreach($services as $index => $service)
        <div class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
    @endforeach
</div>

<div class="footer-fixed">
    <span>🌐 Ecole nizar's de langues</span>
    <span style="text-align: right; font-size: 0.9rem; line-height: 1.4;padding-right: 30px;">
        {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} |
        {{ \Carbon\Carbon::now()->locale('ar')->isoFormat('dddd D MMMM YYYY') }}
    </span>
</div>

<script>
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
</script>
<script>
    function updateTime() {
        const now = new Date();
        const time = now.toLocaleTimeString('fr-FR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('time').textContent = time;
    }

    updateTime(); // initial
    setInterval(updateTime, 1000); // update every second
</script>

@endsection
