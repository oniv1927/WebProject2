@extends('layouts.app')

@section('title', 'Budaya & Sejarah - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Kenali warisan budaya, situs bersejarah, dan tradisi lokal Delta Brantas Sidoarjo.')

@section('content')

    <x-hero
        :compact="true"
        badge="Budaya & Sejarah"
        title='Menyusuri <span class="highlight">Warisan Budaya</span><br>Delta Brantas'
        description="Kenali warisan budaya, situs bersejarah, dan tradisi lokal yang masih lestari di kawasan Delta Brantas."
        image="https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- BUDAYA CATEGORIES --}}
    <section class="section">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Kategori Budaya</span>
                <h2 class="section-title">Jelajahi Warisan Budaya</h2>
                <p class="section-subtitle">Dari batik hingga festival, Delta Brantas menyimpan kekayaan budaya yang beragam.</p>
            </div>

            <div class="cultural-grid">
                @foreach($culturalCategories as $cat)
                    <x-cultural-card :icon="$cat['icon']" :title="$cat['title']" :description="$cat['description']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- SENI & TRADISI --}}
    <section class="section section-alt">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Seni & Tradisi</span>
                    <h2 class="section-title">Seni & Tradisi Lokal</h2>
                </div>
                <p class="section-subtitle">Kesenian dan tradisi turun-temurun yang masih dilestarikan masyarakat Sidoarjo.</p>
            </div>

            <div class="cultural-grid">
                @foreach($arts as $art)
                    <x-cultural-card :icon="$art['icon']" :title="$art['title']" :description="$art['description']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- SITUS SEJARAH --}}
    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Situs Sejarah</span>
                    <h2 class="section-title">Situs Sejarah & Arkeologi</h2>
                </div>
                <p class="section-subtitle">Peninggalan sejarah dari era Majapahit hingga kolonial yang ada di Sidoarjo.</p>
            </div>

            <div class="destination-grid">
                @foreach($historicalSites as $site)
                    <x-destination-card
                        :image="$site['image']"
                        :badge="$site['badge']"
                        :title="$site['title']"
                        :location="$site['location']"
                        :rating="$site['rating']"
                        :description="$site['description']"
                        :url="'/budaya/' . $site['slug']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Jejak Budaya Menanti Anda</h2>
                <p>Temukan lebih banyak situs budaya dan sejarah di Delta Brantas Sidoarjo.</p>
                <a href="/destinasi" class="btn-cta">
                    Mulai Jelajah
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
