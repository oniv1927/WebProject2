@extends('layouts.app')

@section('title', 'Peta Interaktif - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Temukan lokasi wisata, kuliner, dan budaya di peta interaktif Delta Brantas Sidoarjo.')

@section('content')

    <x-hero
        :compact="true"
        badge="Peta Interaktif"
        title='Temukan <span class="highlight">Petualanganmu</span><br>Selanjutnya'
        description="Eksplorasi lokasi wisata, kuliner, dan budaya di peta interaktif Delta Brantas Sidoarjo."
        image="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- MAP SECTION --}}
    <section class="section">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Peta</span>
                <h2 class="section-title">Peta Interaktif Eksplorasi Delta</h2>
                <p class="section-subtitle">Temukan lokasi wisata, kuliner, dan budaya di peta interaktif Delta Brantas.</p>
            </div>

            <div class="map-layout">
                {{-- Sidebar Filter --}}
                <div class="map-sidebar reveal">
                    <h4>Filter Lokasi</h4>
                    <div class="map-filter-list">
                        <label class="map-filter-item active">
                            <input type="checkbox" checked>
                            <span>🌿 Destinasi Alam</span>
                        </label>
                        <label class="map-filter-item">
                            <input type="checkbox" checked>
                            <span>🏛️ Situs Budaya</span>
                        </label>
                        <label class="map-filter-item">
                            <input type="checkbox" checked>
                            <span>🍜 Kuliner</span>
                        </label>
                        <label class="map-filter-item">
                            <input type="checkbox">
                            <span>🏨 Akomodasi</span>
                        </label>
                        <label class="map-filter-item">
                            <input type="checkbox">
                            <span>⛽ Fasilitas Umum</span>
                        </label>
                    </div>

                    <h4>Lokasi Populer</h4>
                    <div class="map-locations-list">
                        @foreach($popularLocations as $loc)
                            <a href="{{ $loc['url'] }}" class="map-location-item">
                                <div class="map-location-icon">{{ $loc['icon'] }}</div>
                                <div>
                                    <span>{{ $loc['title'] }}</span>
                                    <small>{{ $loc['category'] }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Map Container --}}
                <div class="map-main reveal">
                    <div class="map-container" id="map">
                        <div class="map-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                            <p class="map-title">Peta Interaktif</p>
                            <p>Peta akan segera tersedia. Kami sedang menyiapkan pengalaman eksplorasi terbaik untuk Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="section stats-section">
        <div class="container">
            <div class="stats-wrapper">
                <div class="stats-description reveal">
                    <span class="section-label">Statistik</span>
                    <h2>Kawasan Delta Brantas<br>Dalam Angka</h2>
                    <p>Delta Brantas Sidoarjo menyimpan potensi wisata yang luar biasa dengan beragam destinasi, event, dan UMKM aktif.</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card reveal reveal-delay-1">
                        <div class="stat-number" data-target="48" data-suffix="+">0</div>
                        <div class="stat-label">Destinasi Wisata</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-2">
                        <div class="stat-number" data-target="124" data-suffix="">0</div>
                        <div class="stat-label">Event Tahunan</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-3">
                        <div class="stat-number" data-target="350" data-suffix="+">0</div>
                        <div class="stat-label">UMKM Aktif</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-4">
                        <div class="stat-number" data-target="748" data-suffix=" km²">0</div>
                        <div class="stat-label">Luas Kawasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
