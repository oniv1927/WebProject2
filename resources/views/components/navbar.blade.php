{{-- Navbar Component --}}
@php
    $navItems = [
        ['url' => '/', 'label' => 'Beranda'],
        ['url' => '/tentang', 'label' => 'Tentang'],
        ['url' => '/explore', 'label' => 'Explore'],
        ['url' => '/berita', 'label' => 'Berita'],
    ];
@endphp

<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('images/image.png') }}" alt="Logo" style="height: 36px; width: auto; object-fit: contain; margin-right: 8px;">
            <span>Delta Brantas</span>
        </a>

        <div class="navbar-menu">
            @foreach($navItems as $item)
                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @endforeach
        </div>

        <div class="navbar-cta">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="/admin" class="btn btn-primary" style="margin-right: 8px;">Dashboard</a>
                @endif
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="background:transparent;color:#fff;border:1px solid rgba(255,255,255,.2);cursor:pointer;font-family:inherit;font-size:inherit;padding:10px 20px;border-radius:10px;">Logout</button>
                </form>
            @else
                <a href="/login" class="btn btn-primary">Login</a>
            @endauth
        </div>

        <button class="navbar-toggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

