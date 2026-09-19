    @vite('resources/css/auth-pages/verify-email.css')
<x-guest-layout>
<div class="auth-card-header"><div class="auth-kicker">Satu langkah lagi</div><h2>Verifikasi email Anda</h2><p>Untuk menjaga keamanan akun, klik tautan verifikasi yang kami kirim ke email Anda.</p></div>
@if(session('status') == 'verification-link-sent')<div class="auth-status">Tautan verifikasi baru sudah dikirim.</div>@endif
<div class="auth-actions page-style-1" ><form method="POST" action="{{ route('verification.send') }}">@csrf<button class="auth-button" type="submit">Kirim ulang email</button></form><form method="POST" action="{{ route('logout') }}">@csrf<button class="auth-link page-style-2"  type="submit">Keluar</button></form></div>
</x-guest-layout>
