<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kasir Dashboard') - Web Bengkel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/backend/backend.css')

    
    
    @stack('styles')
    @vite('resources/css/backend/cashier.css')
</head>
<body class="backend-page">
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-cash-register me-2"></i> KASIR
        </div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('kasir.dashboard') }}" class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.orders') }}" class="nav-link {{ request()->routeIs('kasir.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i><span>Pesanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.payments') }}" class="nav-link {{ request()->routeIs('kasir.payments') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i><span>Pembayaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kasir.invoices') }}" class="nav-link {{ request()->routeIs('kasir.invoices') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i><span>Invoice</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i><span>Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="content-wrapper">
        <div class="topbar">
            <div class="topbar-title"><i class="fas fa-store me-2 text-warning"></i>@yield('page-title', 'Dashboard Kasir')</div>
            <div class="ms-auto d-flex align-items-center">
                <div class="user-pill">
                    <div class="user-avatar">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto {{ auth()->user()->name }}">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <small class="text-muted role-label">Kasir</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>