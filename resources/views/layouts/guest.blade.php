<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ request()->routeIs('register') ? 'Daftar' : (request()->routeIs('password.*') ? 'Pemulihan Akun' : 'Masuk') }} - {{ config('app.name', 'Web Bengkel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-shell">
        <aside class="auth-aside">
            <a href="{{ url('/') }}" class="auth-brand"><span class="auth-brand-mark">RD</span> RUMAH DAUN</a>
            <div class="auth-aside-copy">
                <div class="auth-kicker">Bengkel otomotif terpercaya</div>
                <h1>Rawat motor. Jalani hari dengan tenang.</h1>
                <p>Kelola booking servis, kendaraan, dan riwayat transaksi dari satu ruang yang sederhana.</p>
            </div>
            <div class="auth-aside-footer">Servis lebih teratur, perjalanan lebih siap.</div>
        </aside>
        <main class="auth-main"><section class="auth-card">{{ $slot }}</section></main>
    </div>
    <script>
        function togglePasswordVisibility(button) {
            const input = document.getElementById(button.dataset.target);
            const icon = button.querySelector('[data-eye-icon]');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            button.setAttribute('title', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            icon.innerHTML = '&#128065;';
        }
    </script>
</body>
</html>
