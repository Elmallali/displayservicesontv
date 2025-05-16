<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Centre de Langues') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Bootstrap JS - Added before Vite to ensure it loads -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vite / Laravel Mix -->
    @vite(['resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1A202C;
            color: #F7FAFC;
        }

        .navbar {
            background-color: #2D3748;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand span {
            color: #F7FAFC;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .nav-link {
            color: #E2E8F0 !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #38B2AC !important;
        }

        .avatar {
            border-radius: 50%;
            width: 32px;
            height: 32px;
        }
        
        .navbar-toggler {
            border-color: #4A5568;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .btn-login, .btn-register {
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
        }
        
        .btn-login {
            background-color: transparent;
            border: 1px solid #38B2AC;
            color: #38B2AC;
        }
        
        .btn-login:hover {
            background-color: rgba(56, 178, 172, 0.1);
            color: #38B2AC;
        }
        
        .btn-register {
            background-color: #38B2AC;
            border: 1px solid #38B2AC;
            color: #F7FAFC;
            margin-left: 0.5rem;
        }
        
        .btn-register:hover {
            background-color: #319795;
            border-color: #319795;
            color: #F7FAFC;
        }
        
        .btn-profile {
            background-color: rgba(56, 178, 172, 0.1);
            border: 1px solid #38B2AC;
            color: #38B2AC;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-profile:hover {
            background-color: rgba(56, 178, 172, 0.2);
            color: #38B2AC;
        }
        
        .btn-logout {
            background-color: rgba(229, 62, 62, 0.1);
            border: 1px solid #E53E3E;
            color: #F56565;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background-color: rgba(229, 62, 62, 0.2);
            color: #F56565;
        }
        
        @media (max-width: 767.98px) {
            .btn-profile, .btn-logout {
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body>
<div id="app">
    @unless (Request::is('public'))
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assests/logo.png') }}" alt="Logo" style="height: 32px;">
                <span>{{ config('app.name', 'Centre de Langues') }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item d-flex align-items-center">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                            </a>
                            <a class="btn btn-register" href="{{ route('public') }}">
                                <i class='bi bi-tv me-1'></i>Ecran Public
                            </a>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center">
                            {{-- <div class="d-flex align-items-center ms-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=38B2AC&color=FFFFFF&size=32" class="avatar me-2" alt="avatar">
                               <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                            </div> --}}
                            
                            <a href="{{ route('profile.show') }}" class="btn btn-profile me-2" title="Consulter votre profil">
                                <i ><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=38B2AC&color=FFFFFF&size=30" class="avatar me-2" alt="avatar"></i>
                                <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                            </a>
                            
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="btn btn-logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="d-none d-md-inline ms-1">Déconnexion</span>
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
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
</html>