    @vite('resources/css/auth-pages/reset-password.css')
<x-guest-layout>
<div class="auth-card-header"><div class="auth-kicker">Pemulihan akun</div><h2>Buat password baru</h2><p>Gunakan password yang kuat dan mudah Anda ingat.</p></div>
<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="auth-field"><label for="email">Email</label><div class="auth-input-wrap has-icon"><span class="auth-input-icon" aria-hidden="true">@</span><input id="email" class="auth-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"></div><x-input-error :messages="$errors->get('email')" class="auth-error" /></div>
    <div class="auth-field"><label for="password">Password baru</label><div class="auth-input-wrap"><input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password"><button type="button" class="auth-toggle-password" data-target="password" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password" title="Tampilkan password"><span data-eye-icon>&#128065;</span></button></div><x-input-error :messages="$errors->get('password')" class="auth-error" /></div>
    <div class="auth-field"><label for="password_confirmation">Ulangi password</label><div class="auth-input-wrap"><input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password"><button type="button" class="auth-toggle-password" data-target="password_confirmation" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password" title="Tampilkan password"><span data-eye-icon>&#128065;</span></button></div><x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" /></div>
    <button class="auth-button page-style-1"  type="submit">Simpan password <span aria-hidden="true">&rarr;</span></button>
</form>
</x-guest-layout>
