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
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        :root {
            --primary: #3563E9;
            --primary-light: #4A7CF6;
            --primary-dark: #2A4FBA;
            --secondary: #121A2D;
            --accent: #4FBAEE;
            --accent-light: #82CEF9;
            --accent-dark: #3394CD;
            --background: #0F172A;
            --card-bg: rgba(51, 148, 205, 0.15);
            --text: #F0F8FF;
            --text-secondary: #CBD5E1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --gradient: linear-gradient(135deg, var(--accent-dark), var(--accent-light));
            --hover-gradient: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            background-image: radial-gradient(circle at 10% 20%, rgba(51, 148, 205, 0.03) 0%, rgba(30, 41, 59, 0.03) 90%);
            background-attachment: fixed;
            line-height: 1.6;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--accent-dark);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Navbar styling */
        .navbar {
            background-color: rgba(18, 26, 45, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(79, 186, 238, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand span {
            color: var(--accent-light);
            font-weight: 600;
            font-size: 1.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 0 3px;
        }
        
        .nav-link:hover {
            background-color: rgba(79, 186, 238, 0.1);
            color: var(--accent-light) !important;
            transform: translateY(-2px);
        }
        
        /* Button styles */
        .btn-primary {
            background: var(--gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(51, 148, 205, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--hover-gradient);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(51, 148, 205, 0.4);
        }
        
        .btn-secondary {
            background-color: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: rgba(79, 186, 238, 0.1);
            color: var(--accent-light);
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background-color: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background-color: var(--danger);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Card styles */
        .card {
            background-color: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }
        
        .card-header {
            background-color: rgba(51, 148, 205, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            font-weight: 600;
            color: var(--accent-light);
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Table styles */
        .table {
            color: var(--text);
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        
        .table thead th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--accent-light);
            font-weight: 600;
            padding: 12px 15px;
            background-color: rgba(51, 148, 205, 0.05);
        }
        
        .table tbody tr {
            background-color: rgba(255, 255, 255, 0.03);
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
            transform: scale(1.01);
        }
        
        .table td {
            padding: 12px 15px;
            border-top: none;
            vertical-align: middle;
        }
        
        /* Form styles */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
            color: var(--text);
            box-shadow: 0 0 0 0.25rem rgba(79, 186, 238, 0.25);
        }
        
        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .form-select option {
            background-color: var(--secondary);
            color: var(--text);
        }
        
        /* Alert styles */
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: #10B981;
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #EF4444;
        }
        
        .alert-info {
            background-color: rgba(79, 186, 238, 0.1);
            border-color: rgba(79, 186, 238, 0.2);
            color: #4FBAEE;
        }
        
        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.2);
            color: #F59E0B;
        }

        /* Home page styles */
        .home-container {
            padding: 2rem 0;
        }
        
        .home-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--accent-light);
            text-align: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.3s ease;
        }
        
        .card-link:hover {
            transform: translateY(-8px);
        }
        
        .card-icon {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 1rem;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .card-link:hover .card-icon {
            color: var(--accent-light);
            transform: scale(1.1);
        }
        
        /* Badge styles */
        .badge {
            padding: 0.4em 0.8em;
            font-weight: 500;
            border-radius: 6px;
        }
        
        .badge-primary {
            background-color: rgba(53, 99, 233, 0.2);
            color: var(--primary-light);
        }
        
        .badge-success {
            background-color: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }
        
        .badge-warning {
            background-color: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }
        
        .badge-danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }
        
        /* Animation effects */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="bi bi-people"></i> {{ __('Gestion des utilisateurs') }}
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
                
                <!-- Right Side Of Navbar -->
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