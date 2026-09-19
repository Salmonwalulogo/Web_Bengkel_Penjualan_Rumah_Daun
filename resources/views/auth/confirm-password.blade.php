    @vite('resources/css/auth-pages/confirm-password.css')
<x-guest-layout>
<div class="auth-card-header"><div class="auth-kicker">Verifikasi keamanan</div><h2>Konfirmasi password</h2><p>Untuk melanjutkan ke area aman, masukkan password akun Anda.</p></div>
<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="auth-field"><label for="password">Password</label><div class="auth-input-wrap"><input id="password" class="auth-input" type="password" name="password" required autofocus autocomplete="current-password"><button type="button" class="auth-toggle-password" data-target="password" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password" title="Tampilkan password"><span data-eye-icon>&#128065;</span></button></div><x-input-error :messages="$errors->get('password')" class="auth-error" /></div>
    <button class="auth-button page-style-1"  type="submit">Konfirmasi <span aria-hidden="true">&rarr;</span></button>
</form>
</x-guest-layout>
