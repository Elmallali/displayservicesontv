<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/js/app.js']) {{-- هاد السطر إلا كنت خدام بـ Vite --}}
</head>
<body>
    <div id="app">
        {{-- إخفاء Navbar إذا كنا في صفحة /public --}}
        @unless (Request::is('public'))
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <div class="container">

        {{-- ✅ Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <img src="{{ asset('assests/logo.png') }}" alt="Logo" style="height: 32px;">
            <span class="fw-bold">{{ config('app.name', 'Centre de Langues') }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto"></ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-black" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="{{ route('register') }}">Inscription</a>
                    </li>
                @else
                    {{-- ✅ Avatar + Name Dropdown --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-black d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=0044cc&size=32"
                                 class="rounded-circle" width="32" height="32" alt="avatar">
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('profile.show') }}">👤 Mon Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                🚪 Déconnexion
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>



        @endunless

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
