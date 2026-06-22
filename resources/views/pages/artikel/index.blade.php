@extends('layouts.app')

@section('title', 'Artikel & Berita - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Baca artikel terbaru seputar wisata, budaya, kuliner, dan event di Delta Brantas Sidoarjo.')

@section('content')

    <x-hero
        :compact="true"
        badge="Artikel & Berita"
        title='Dapatkan <span class="highlight">Kabar Terkini</span><br>dari Delta Brantas'
        description="Informasi terbaru seputar wisata, budaya, event, dan kuliner di kawasan Delta Brantas Sidoarjo."
        image="https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- ARTIKEL GRID --}}
    <section class="section">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Semua Artikel</span>
                    <h2 class="section-title">Berita Terbaru</h2>
                </div>
                <p class="section-subtitle">Jangan lewatkan informasi terkini seputar Delta Brantas Sidoarjo.</p>
            </div>

            <div class="article-grid">
                @foreach($articles as $article)
                    <x-article-card :image="$article['image']" :date="$article['date']" :title="$article['title']" :excerpt="$article['excerpt']" :url="$article['url']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- NEWSLETTER CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Dapatkan Kabar Terkini</h2>
                <p>Berlangganan newsletter kami untuk mendapatkan update terbaru seputar Delta Brantas.</p>
                <form class="newsletter-form" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Masukkan email Anda" class="newsletter-input">
                    <button type="submit" class="btn-cta">Daftar Sekarang</button>
                </form>
            </div>
        </div>
    </section>

@endsection
