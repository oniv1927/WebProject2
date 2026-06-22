@extends('layouts.app')

@section('title', $category->name . ' - Explore Delta Brantas Sidoarjo')
@section('meta_description', 'Jelajahi ' . $category->name . ' di Delta Brantas Sidoarjo. ' . $category->description)

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        :badge="$category->icon . ' ' . $category->name"
        :title="'Menjelajahi ' . ($category->slug === 'wisata-alam' ? 'Nafas Alam' : ($category->slug === 'kuliner' ? 'Cita Rasa' : ($category->slug === 'budaya' ? 'Warisan Budaya' : 'Jejak Sejarah'))) . '<br><span class=\'highlight\'>di Delta Brantas</span>'"
        :description="$category->description"
        :image="$category->image"
    />

    {{-- FILTER PILLS + SEARCH --}}
    <section class="section explore-filter-section" style="padding-bottom: 40px;">
        <div class="container">
            <div class="explore-filter-pills reveal">
                <a href="/explore" class="explore-pill">Semua</a>
                @foreach($categories as $cat)
                    <a href="/explore/{{ $cat->slug }}" class="explore-pill {{ $cat->slug === $category->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            <div class="explore-search reveal" style="margin-top: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Cari {{ strtolower($category->name) }}..." class="explore-search-input">
            </div>
        </div>
    </section>

    {{-- FEATURED DESTINATION --}}
    @if($featured)
    <section class="section" style="padding-top: 0;">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Unggulan</span>
                    <h2 class="section-title">{{ $featured->name }}</h2>
                </div>
                <p class="section-subtitle">{{ $featured->description }}</p>
            </div>

            <div class="destination-card featured-card reveal">
                <div class="destination-card-image featured-image">
                    <img src="{{ $featured->image }}" alt="{{ $featured->name }}" loading="lazy">
                    <div class="card-overlay"></div>
                    @if($featured->badge)
                        <span class="card-badge">{{ $featured->badge }}</span>
                    @endif
                </div>
                <div class="destination-card-body">
                    <h3>
                        <a href="/explore/{{ $category->slug }}/{{ $featured->slug }}">{{ $featured->name }}</a>
                    </h3>
                    <div class="card-location">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $featured->location }}
                    </div>
                    <div class="card-rating">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span>{{ $featured->rating }}</span>
                    </div>
                    <a href="/explore/{{ $category->slug }}/{{ $featured->slug }}" class="btn btn-primary btn-sm">
                        Jelajahi
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17l9.2-9.2M17 17V7H7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- GRID DESTINATIONS --}}
    <section class="section" style="padding-top: {{ $featured ? '0' : '0' }};">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Semua {{ $category->name }}</span>
                <h2 class="section-title">Daftar {{ $category->name }}</h2>
            </div>

            <div class="destination-grid">
                @foreach($regularItems as $item)
                    <x-destination-card
                        :image="$item->image"
                        :badge="$item->badge"
                        :title="$item->name"
                        :location="$item->location"
                        :rating="$item->rating"
                        :description="$item->description"
                        :url="'/explore/' . $category->slug . '/' . $item->slug"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- REKOMENDASI PERJALANAN --}}
    <section class="section section-alt">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Rekomendasi</span>
                <h2 class="section-title">Rekomendasi Perjalanan</h2>
                <p class="section-subtitle">Rute perjalanan terbaik untuk menjelajahi {{ strtolower($category->name) }} di Delta Brantas.</p>
            </div>

            <div class="recommendation-grid">
                <div class="recommendation-card reveal reveal-delay-1">
                    
                    <h4>Rute 1 Hari</h4>
                    <p>Jelajahi 3 destinasi {{ strtolower($category->name) }} terbaik dalam satu hari penuh.</p>
                    <a href="/explore" class="recommendation-link">Lihat Rute</a>
                </div>
                <div class="recommendation-card reveal reveal-delay-2">
                    
                    <h4>Rute 2 Hari</h4>
                    <p>Pengalaman lebih mendalam dengan 6 destinasi dan akomodasi lokal.</p>
                    <a href="/explore" class="recommendation-link">Lihat Rute</a>
                </div>
                <div class="recommendation-card reveal reveal-delay-3">
                    
                    <h4>Rute 3 Hari</h4>
                    <p>Petualangan lengkap menjelajahi seluruh kawasan Delta Brantas.</p>
                    <a href="/explore" class="recommendation-link">Lihat Rute</a>
                </div>
            </div>
        </div>
    </section>

    {{-- MINI MAP --}}
    <section class="section">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Peta</span>
                <h2 class="section-title">Lokasi {{ $category->name }}</h2>
            </div>

            <div class="mini-map-container reveal">
                <div class="map-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                    <p class="map-title">Peta {{ $category->name }}</p>
                    <p>Peta lokasi akan segera tersedia.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
