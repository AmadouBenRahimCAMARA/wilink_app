<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wilink App') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap & Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="{{ Request::is('login') || Request::is('register') || Request::is('password/*') ? 'login-page' : '' }}">
    
    <div id="app">
        @auth
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-header d-flex justify-content-between align-items-center px-3">
                     <a href="{{ url('/') }}" class="sidebar-brand">
                        <i class="fa-solid fa-wifi me-2"></i>WILINK
                     </a>
                     <button id="sidebarClose" class="btn btn-link text-white d-md-none p-0">
                        <i class="fa-solid fa-times fa-lg"></i>
                     </button>
                </div>
                <ul class="nav flex-column sidebar-nav">
                    
                    @if(auth()->user()->role_id == 1) <!-- Admin -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.tickets.index') ? 'active' : '' }}" href="{{ route('admin.tickets.index') }}">
                                <i class="fa-solid fa-ticket"></i> Gestion Tickets
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.revendeurs.index') ? 'active' : '' }}" href="{{ route('admin.revendeurs.index') }}">
                                <i class="fa-solid fa-users"></i> Revendeurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.reglements.index') ? 'active' : '' }}" href="{{ route('admin.reglements.index') }}">
                                <i class="fa-solid fa-money-bill-transfer"></i> Règlements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                                <i class="fa-solid fa-chart-line"></i> Rapports
                            </a>
                        </li>
                    @elseif(auth()->user()->role_id == 2) <!-- Revendeur -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('reseller.dashboard') ? 'active' : '' }}" href="{{ route('reseller.dashboard') }}">
                                <i class="fa-solid fa-store"></i> Point de Vente
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('reseller.sales.index') ? 'active' : '' }}" href="{{ route('reseller.sales.index') }}">
                                <i class="fa-solid fa-list"></i> Mes Ventes
                            </a>
                        </li>
                    @endif

                    <li class="nav-item mt-5 border-top border-secondary pt-3">
                         <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                         </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Top Navbar -->
            <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button id="sidebarToggle" class="btn btn-link text-dark me-3 d-md-none">
                        <i class="fa-solid fa-bars fa-lg"></i>
                    </button>
                    <h4 class="mb-0 fw-bold text-dark">
                        @yield('page-title', 'Tableau de Bord')
                    </h4>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-3 fw-bold text-secondary-custom d-none d-md-block">{{ Auth::user()->name }}</span>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                {{ substr(Auth::user()->prenom, 0, 1) }}{{ substr(Auth::user()->nom, 0, 1) }}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen me-2 text-muted"></i>Mon Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-sign-out-alt me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="main-content">
                @yield('content')
            </main>

        @else
            <!-- Layout pour Guest (Login) -->
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebar = document.querySelector('.sidebar');
            
            function toggleSidebar() {
                sidebar.classList.toggle('active');
            }

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose && sidebar) {
                sidebarClose.addEventListener('click', toggleSidebar);
            }
        });
    </script>

</body>
</html>
