    @vite('resources/css/auth-pages/forgot-password.css')
<x-guest-layout>
<div class="auth-card-header"><div class="auth-kicker">Pemulihan akun</div><h2>Atur ulang password</h2><p>Masukkan email Anda. Kami akan mengirim tautan untuk membuat password baru.</p></div>
<x-auth-session-status class="auth-status" :status="session('status')" />
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="auth-field"><label for="email">Email</label><input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"><x-input-error :messages="$errors->get('email')" class="auth-error" /></div>
    <button class="auth-button page-style-1"  type="submit">Kirim tautan reset <span aria-hidden="true">&rarr;</span></button>
</form>
<div class="auth-bottom"><a class="auth-link" href="{{ route('login') }}">&larr; Kembali ke login</a></div>
</x-guest-layout>
