<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Portal Wisata & Budaya Delta Brantas Sidoarjo')">
    <title>@yield('title', 'Portal Wisata & Budaya Delta Brantas Sidoarjo')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Mobile Menu --}}
    <div class="mobile-menu">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
        <a href="/tentang" class="{{ request()->is('tentang*') ? 'active' : '' }}">Tentang</a>
        <a href="/explore" class="{{ request()->is('explore*') ? 'active' : '' }}">Explore</a>
        <a href="/berita" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="/admin" class="btn btn-primary" style="margin-top: 16px;">Dashboard</a>
            @endif
            <form method="POST" action="/logout" style="margin-top: 8px;">
                @csrf
                <button type="submit" class="btn btn-outline" style="width:100%;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.2);cursor:pointer;font-family:inherit;padding:12px;border-radius:10px;">Logout</button>
            </form>
        @else
            <a href="/login" class="btn btn-primary" style="margin-top: 16px;">Login</a>
        @endauth
    </div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
