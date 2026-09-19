<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Dashboard') - Web Bengkel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/backend/backend.css')

    <!-- Custom CSS -->
    
    
    @stack('styles')
    @vite('resources/css/backend/customer.css')
</head>
<body class="backend-page">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-user me-2"></i>
            CUSTOMER
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('produk') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-basket"></i>
                    Keranjang
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.booking.create') }}" class="nav-link {{ request()->routeIs('customer.booking.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-plus"></i>
                    Booking Servis
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.vehicles') }}" class="nav-link {{ request()->routeIs('customer.vehicles*') ? 'active' : '' }}">
                    <i class="fas fa-car"></i>
                    Kendaraan Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.transactions') }}" class="nav-link {{ request()->routeIs('customer.transactions') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customer.notifications') }}" class="nav-link {{ request()->routeIs('customer.notifications*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    Notifikasi
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <button type="button" class="mobile-menu-toggle" onclick="toggleSidebar()" aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3 text-gray-600">Halo, {{ auth()->user()->name }}</span>
                <span class="badge bg-success">{{ auth()->user()->role_name }}</span>
                <span class="user-avatar ms-3">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto {{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
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