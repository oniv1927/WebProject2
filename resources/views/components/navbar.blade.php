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
            <span class="brand-icon">🌊</span>
            <span>Delta Brantas</span>
        </a>

        <div class="navbar-menu">
            @foreach($navItems as $item)
                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @endforeach
        </div>

        <div class="navbar-cta">
            <a href="/admin" class="btn btn-primary">Login Admin</a>
        </div>

        <button class="navbar-toggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>
