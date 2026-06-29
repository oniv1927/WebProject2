@extends('layouts.app')

@section('title', 'Login - Portal Wisata & Budaya Delta Brantas')

@push('styles')
<style>
.auth-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 24px 80px;
    background: var(--bg-dark, #0a0f1a);
}
.auth-card {
    width: 100%;
    max-width: 440px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 20px;
    padding: 48px 40px;
    backdrop-filter: blur(12px);
}
.auth-card-header {
    text-align: center;
    margin-bottom: 36px;
}
.auth-card-header .auth-icon {
    font-size: 2.5rem;
    margin-bottom: 12px;
    display: block;
}
.auth-card-header h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
}
.auth-card-header p {
    font-size: .9rem;
    color: #94a3b8;
}
.auth-form .form-group {
    margin-bottom: 20px;
}
.auth-form label {
    display: block;
    font-size: .85rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 8px;
}
.auth-form input[type="email"],
.auth-form input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 12px;
    color: #fff;
    font-size: .95rem;
    font-family: inherit;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.auth-form input:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,.15);
}
.auth-form input::placeholder {
    color: #475569;
}
.auth-form .form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
}
.auth-form .form-check input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #22c55e;
    cursor: pointer;
}
.auth-form .form-check label {
    font-size: .85rem;
    color: #94a3b8;
    margin-bottom: 0;
    cursor: pointer;
}
.auth-form .btn-login {
    width: 100%;
    padding: 14px;
    background: #22c55e;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background .2s, transform .1s;
}
.auth-form .btn-login:hover {
    background: #16a34a;
}
.auth-form .btn-login:active {
    transform: scale(.98);
}
.auth-error {
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.25);
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 20px;
    color: #fca5a5;
    font-size: .85rem;
}
.auth-footer {
    text-align: center;
    margin-top: 24px;
}
.auth-footer a {
    color: #22c55e;
    font-size: .85rem;
    text-decoration: none;
    transition: color .2s;
}
.auth-footer a:hover {
    color: #16a34a;
    text-decoration: underline;
}
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="auth-card reveal">
        <div class="auth-card-header">
            <span class="auth-icon">🔐</span>
            <h1>Login Admin</h1>
            <p>Masuk ke Dashboard Admin Delta Brantas</p>
        </div>

        @if($errors->any())
            <div class="auth-error">
                @foreach($errors->all() as $error)
                    <p style="margin:0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="auth-footer">
            <a href="/">← Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
