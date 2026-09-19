<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Web Bengkel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/backend/backend.css')

    
    
    @stack('styles')
    @vite('resources/css/backend/admin.css')
</head>
<body class="backend-page">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand" onclick="window.location.href='{{ route('admin.dashboard') }}'">
            <i class="fas fa-tools"></i>
            ADMIN PANEL
        </div>
        <ul class="sidebar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <!-- Master Data (Dropdown) -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleSubmenu(event, 'submenu-master')">
                    <i class="fas fa-database"></i> Master Data
                    <i class="fas fa-chevron-right arrow" id="arrow-master"></i>
                </a>
                <ul class="submenu" id="submenu-master">
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <i class="fas fa-wrench"></i> Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.vehicles.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                            <i class="fas fa-motorcycle"></i> Kendaraan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Booking (Single) -->
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Booking
                </a>
            </li>

            <!-- Keuangan (Dropdown) -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleSubmenu(event, 'submenu-keuangan')">
                    <i class="fas fa-money-bill-wave"></i> Keuangan
                    <i class="fas fa-chevron-right arrow" id="arrow-keuangan"></i>
                </a>
                <ul class="submenu" id="submenu-keuangan">
                    <li class="nav-item">
                        <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                            <i class="fas fa-credit-card"></i> Pembayaran
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Manajemen (Dropdown) -->
            <li class="nav-item">
                <a href="#" class="nav-link dropdown-toggle" onclick="toggleSubmenu(event, 'submenu-manajemen')">
                    <i class="fas fa-cogs"></i> Manajemen
                    <i class="fas fa-chevron-right arrow" id="arrow-manajemen"></i>
                </a>
                <ul class="submenu" id="submenu-manajemen">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                            <i class="fas fa-bell"></i> Notifikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.contact-messages.index') }}" class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i> Pesan Kontak
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Pengaturan (Dropdown) -->
<li class="nav-item">
    <a href="#" class="nav-link dropdown-toggle" onclick="toggleSubmenu(event, 'submenu-pengaturan')">
        <i class="fas fa-cog"></i> Pengaturan
        <i class="fas fa-chevron-right arrow" id="arrow-pengaturan"></i>
    </a>
    <ul class="submenu" id="submenu-pengaturan">
        <li class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i> Profil & Keamanan
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.profile') }}" class="nav-link {{ request()->routeIs('admin.settings.profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profil Saya
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.account') }}" class="nav-link {{ request()->routeIs('admin.settings.account') ? 'active' : '' }}">
                <i class="fas fa-key"></i> Akun & Keamanan
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.general') }}" class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                <i class="fas fa-store"></i> Pengaturan Bengkel
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.notification') }}" class="nav-link {{ request()->routeIs('admin.settings.notification') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Notifikasi
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.backup') }}" class="nav-link {{ request()->routeIs('admin.settings.backup') ? 'active' : '' }}">
                <i class="fas fa-database"></i> Backup & Restore
            </a>
        </li>
    </ul>
</li>

            <!-- Laporan (Single) -->
            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link page-style-1" >
                        <i class="fas fa-sign-out-alt"></i> Logout
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
            <div class="d-flex align-items-center">
                <!-- Tombol Kembali ke Dashboard -->
                @if(!request()->routeIs('admin.dashboard'))
                <a href="{{ route('admin.dashboard') }}" class="btn-back-dashboard me-3">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
                @endif
                
                <!-- Page Title -->
                <h4 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h4>
            </div>
            
            <div class="ms-auto d-flex align-items-center">
                <span class="me-3">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <span class="badge bg-primary badge-role">{{ ucfirst(auth()->user()->role) }}</span>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Submenu
        function toggleSubmenu(event, submenuId) {
            event.preventDefault();
            const submenu = document.getElementById(submenuId);
            const arrow = document.getElementById('arrow-' + submenuId.replace('submenu-', ''));
            
            submenu.classList.toggle('show');
            arrow.classList.toggle('rotated');
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
            document.querySelector('.sidebar-backdrop').classList.toggle('show');
        }

        // Auto-open submenu if active
        document.addEventListener('DOMContentLoaded', function() {
            const activeLinks = document.querySelectorAll('.submenu .nav-link.active');
            activeLinks.forEach(link => {
                const submenu = link.closest('.submenu');
                if (submenu) {
                    submenu.classList.add('show');
                    const arrowId = 'arrow-' + submenu.id.replace('submenu-', '');
                    const arrow = document.getElementById(arrowId);
                    if (arrow) {
                        arrow.classList.add('rotated');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>