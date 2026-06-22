@extends('layouts.app')

@section('title', 'Kuliner Khas - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Nikmati cita rasa otentik kuliner khas Sidoarjo. Dari kupang lontong hingga petis udang legendaris.')

@section('content')

    <x-hero
        :compact="true"
        badge="Kuliner Khas"
        title='Jelajahi <span class="highlight">Cita Rasa</span><br>Ongklik Sidoarjo'
        description="Nikmati cita rasa otentik kuliner khas Sidoarjo yang melegenda dan menggugah selera."
        image="https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- KULINER GRID --}}
    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Semua Kuliner</span>
                    <h2 class="section-title">Kuliner Khas Sidoarjo</h2>
                </div>
                <p class="section-subtitle">Cita rasa otentik yang hanya bisa ditemukan di tanah Delta Brantas.</p>
            </div>

            <div class="food-grid">
                @foreach($foods as $food)
                    <x-food-card :image="$food['image']" :title="$food['title']" :description="$food['description']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- REKOMENDASI TEMPAT MAKAN --}}
    <section class="section section-alt">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Rekomendasi</span>
                    <h2 class="section-title">Tempat Makan Terbaik</h2>
                </div>
                <p class="section-subtitle">Rekomendasi tempat makan terbaik untuk menikmati kuliner khas Sidoarjo.</p>
            </div>

            <div class="destination-grid">
                @foreach($restaurants as $rest)
                    <x-destination-card
                        :image="$rest['image']"
                        :badge="$rest['badge']"
                        :title="$rest['title']"
                        :location="$rest['location']"
                        :rating="$rest['rating']"
                        :description="$rest['description']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Lapar? Yuk Jelajahi Kuliner Sidoarjo!</h2>
                <p>Temukan kuliner lezat di setiap sudut Delta Brantas.</p>
                <a href="/peta" class="btn-cta">
                    Cari di Peta
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
