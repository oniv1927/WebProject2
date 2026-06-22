@extends('layouts.app')

@section('title', 'Berita - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Berita terbaru seputar wisata, budaya, kuliner, dan event di Delta Brantas Sidoarjo.')

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        badge="Berita Terbaru"
        title='Informasi Terkini<br><span class="highlight">Delta Brantas</span>'
        description="Dapatkan berita terbaru seputar wisata, budaya, kuliner, dan event menarik di kawasan Delta Brantas Sidoarjo."
        image="https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- BERITA GRID --}}
    <section class="section">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Semua Berita</span>
                <h2 class="section-title">Berita & Artikel Terbaru</h2>
                <p class="section-subtitle">Informasi terkini seputar perkembangan wisata, budaya, dan kreativitas di Delta Brantas.</p>
            </div>

            <div class="article-grid">
                @foreach($articles as $article)
                    <x-article-card
                        :image="$article->image"
                        :date="\Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y')"
                        :title="$article->title"
                        :excerpt="$article->excerpt"
                        :url="'/berita/' . $article->slug"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Punya Cerita Menarik<br>tentang Delta Brantas?</h2>
                <p>Kirimkan cerita atau berita Anda untuk dipublikasikan di portal kami.</p>
                <a href="/explore" class="btn-cta">
                    Jelajahi Delta Brantas
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
