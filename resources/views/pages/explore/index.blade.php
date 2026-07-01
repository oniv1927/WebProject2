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
        image="images/explore-hero.png"
    />

    {{-- CATEGORY FILTER PILLS --}}
    <section class="section explore-filter-section">
        <div class="container">
            <div class="explore-filter-pills reveal">
                <a href="/explore" class="explore-pill active">Semua</a>
                <a href="/explore/wisata-alam" class="explore-pill">Wisata Alam</a>
                <a href="/explore/kuliner" class="explore-pill">Kuliner</a>
                <a href="/explore/budaya-sejarah" class="explore-pill">Budaya & Sejarah</a>
            </div>

            {{-- EXPLORE CATEGORY CARDS --}}
            <div class="explore-category-grid" style="margin-top: 48px;">
                {{-- Wisata Alam --}}
                @php
                    $alamCat = $categories->firstWhere('slug', 'wisata-alam');
                    $kulinerCat = $categories->firstWhere('slug', 'kuliner');
                    $budayaCat = $categories->firstWhere('slug', 'budaya');
                @endphp
                @if($alamCat)
                    <a href="/explore/wisata-alam" class="explore-category-card reveal reveal-delay-1">
                        <div class="explore-category-image">
                            <img src="@imgurl($alamCat->image)" alt="{{ $alamCat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $alamCat->destinations_count ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $alamCat->icon }}</span>
                            <h3>{{ $alamCat->name }}</h3>
                            <p>{{ $alamCat->description }}</p>
                            <span class="explore-category-link">
                                Jelajahi
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endif
                {{-- Kuliner --}}
                @if($kulinerCat)
                    <a href="/explore/kuliner" class="explore-category-card reveal reveal-delay-2">
                        <div class="explore-category-image">
                            <img src="@imgurl($kulinerCat->image)" alt="{{ $kulinerCat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $kulinerCat->destinations_count ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $kulinerCat->icon }}</span>
                            <h3>{{ $kulinerCat->name }}</h3>
                            <p>{{ $kulinerCat->description }}</p>
                            <span class="explore-category-link">
                                Jelajahi
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endif
                {{-- Budaya & Sejarah (combined) --}}
                @if($budayaCat)
                    <a href="/explore/budaya-sejarah" class="explore-category-card reveal reveal-delay-3">
                        <div class="explore-category-image">
                            <img src="{{ asset('storage/images/fotokitablur/brantas.png') }}"
     alt="Delta Brantas Sidoarjo">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $budayaSejarahCount ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">🏛️</span>
                            <h3>Budaya & Sejarah</h3>
                            <p>Jelajahi warisan budaya dan situs bersejarah Delta Brantas.</p>
                            <span class="explore-category-link">
                                Jelajahi
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endif
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
