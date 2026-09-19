<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mekanik') - Rumah Daun Bengkel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/backend/backend.css')
    
    
    @vite('resources/css/backend/mechanic.css')
</head>
<body class="backend-page">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3><i class="bi bi-wrench-adjustable"></i> MEKANIK</h3>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('mekanik.dashboard') }}" class="{{ request()->routeIs('mekanik.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('mekanik.bookings') }}" class="{{ request()->routeIs('mekanik.bookings') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Booking Servis
                </a>
            </li>
            <li>
                <a href="{{ route('mekanik.jobs') }}" class="{{ request()->routeIs('mekanik.jobs') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i> Pekerjaan
                </a>
            </li>
            <li>
                <a href="{{ route('mekanik.history') }}" class="{{ request()->routeIs('mekanik.history') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </li>
        </ul>

        <div class="sidebar-logout">
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Content -->
    <div class="content">
        <!-- Topbar -->
        <div class="topbar">
            <button type="button" class="mobile-menu-toggle" onclick="toggleSidebar()" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div class="user-info">
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Mekanik</div>
                </div>
                <div class="user-avatar">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto {{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Main Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
            document.querySelector('.sidebar-backdrop').classList.toggle('show');
        }
    </script>
    @stack('scripts')
</body>
</html>