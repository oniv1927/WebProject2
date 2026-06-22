@extends('layouts.app')

@section('title', 'Explore - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Jelajahi semua kategori wisata di Delta Brantas: wisata alam, kuliner, budaya, dan sejarah.')

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        badge="Explore"
        title='Jelajahi Keajaiban<br><span class="highlight">Delta Brantas</span>'
        description="Temukan pengalaman wisata yang sesuai dengan minat Anda. Dari alam yang memukau hingga budaya yang kaya."
        image="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- CATEGORY FILTER PILLS --}}
    <section class="section explore-filter-section">
        <div class="container">
            <div class="explore-filter-pills reveal">
                <a href="/explore" class="explore-pill active">Semua</a>
                @foreach($categories as $cat)
                    <a href="/explore/{{ $cat->slug }}" class="explore-pill">{{ $cat->name }}</a>
                @endforeach
            </div>

            {{-- EXPLORE CATEGORY CARDS --}}
            <div class="explore-category-grid" style="margin-top: 48px;">
                @foreach($categories as $cat)
                    <a href="/explore/{{ $cat->slug }}" class="explore-category-card reveal reveal-delay-{{ $loop->iteration }}">
                        <div class="explore-category-image">
                            <img src="{{ $cat->image }}" alt="{{ $cat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $cat->destinations_count ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $cat->icon }}</span>
                            <h3>{{ $cat->name }}</h3>
                            <p>{{ $cat->description }}</p>
                            <span class="explore-category-link">
                                Jelajahi
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- INTERACTIVE MAP SECTION --}}
    <section class="section section-alt">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Peta</span>
                <h2 class="section-title">Peta Interaktif<br>Eksplorasi Delta</h2>
                <p class="section-subtitle">Temukan lokasi wisata, kuliner, dan budaya di peta interaktif Delta Brantas.</p>
            </div>

            <div class="map-explore-grid reveal">
                <div class="map-explore-info">
                    <div class="map-explore-stat-row">
                        <div class="map-explore-stat">
                            <span class="map-explore-stat-number">12</span>
                            <span class="map-explore-stat-label">Titik Alam</span>
                        </div>
                        <div class="map-explore-stat">
                            <span class="map-explore-stat-number">25</span>
                            <span class="map-explore-stat-label">Destinasi Kuliner</span>
                        </div>
                    </div>
                    <p style="color: var(--text-secondary); margin-top: 16px;">Peta interaktif akan segera tersedia. Kami sedang menyiapkan pengalaman eksplorasi terbaik untuk Anda.</p>
                </div>
                <div class="map-explore-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                    <p>Peta Interaktif</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Siap Menemukan Keajaiban<br>Sidoarjo?</h2>
                <p>Mulai perjalanan Anda menjelajahi keindahan Delta Brantas hari ini juga.</p>
                <a href="/explore/wisata-alam" class="btn-cta">
                    Mulai Jelajahi
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
