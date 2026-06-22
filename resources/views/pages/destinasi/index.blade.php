@extends('layouts.app')

@section('title', 'Destinasi Wisata - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Temukan destinasi wisata terbaik di Delta Brantas Sidoarjo. Dari hutan mangrove hingga pantai eksotis.')

@section('content')

    <x-hero
        :compact="true"
        badge="Destinasi Wisata"
        title='Jelajahi <span class="highlight">Keajaiban</span><br>Delta Brantas'
        description="Temukan destinasi wisata yang menakjubkan di kawasan Delta Brantas Sidoarjo."
        image="https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=2070&auto=format&fit=crop"
        :buttons="[
            ['url' => '#semua', 'label' => 'Semua', 'style' => 'btn-primary'],
            ['url' => '#alam', 'label' => 'Alam', 'style' => 'btn-outline'],
            ['url' => '#sejarah', 'label' => 'Sejarah', 'style' => 'btn-outline'],
        ]"
    />

    {{-- DESTINASI GRID --}}
    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Semua Destinasi</span>
                    <h2 class="section-title">Destinasi Unggulan</h2>
                </div>
                <p class="section-subtitle">Tempat-tempat terbaik yang wajib dikunjungi di kawasan Delta Brantas Sidoarjo.</p>
            </div>

            <div class="destination-grid">
                @foreach($destinations as $dest)
                    <x-destination-card
                        :image="$dest['image']"
                        :badge="$dest['badge']"
                        :title="$dest['title']"
                        :location="$dest['location']"
                        :rating="$dest['rating']"
                        :description="$dest['description']"
                        :url="'/destinasi/' . $dest['slug']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Temukan Destinasi Favoritmu</h2>
                <p>Jelajahi lebih banyak tempat menarik di Delta Brantas Sidoarjo.</p>
                <a href="/peta" class="btn-cta">
                    Lihat di Peta
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
