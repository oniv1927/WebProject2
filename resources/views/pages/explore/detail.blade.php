@extends('layouts.app')

@section('title', $item->name . ' - ' . $category->name . ' Delta Brantas Sidoarjo')
@section('meta_description', $item->description)

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        :badge="$category->icon . ' ' . $category->name"
        :title="$item->name"
        :description="$item->description"
        :image="$item->image"
    />

    {{-- BREADCRUMB --}}
    <section class="section" style="padding-bottom: 0;">
        <div class="container">
            <div class="detail-breadcrumb reveal">
                <a href="/">Beranda</a>
                <span>/</span>
                <a href="/explore">Explore</a>
                <span>/</span>
                <a href="/explore/{{ $category->slug }}">{{ $category->name }}</a>
                <span>/</span>
                <span class="current">{{ $item->name }}</span>
            </div>
        </div>
    </section>

    {{-- DETAIL CONTENT --}}
    <section class="section">
        <div class="container">
            <div class="detail-layout">
                {{-- MAIN CONTENT --}}
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}">
                    </div>

                    <div class="detail-meta reveal">
                        @if($item->badge)
                            <span class="detail-badge">{{ $item->badge }}</span>
                        @endif
                        <div class="detail-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span>{{ $item->rating }}</span>
                        </div>
                    </div>

                    <h1 class="detail-title reveal">{{ $item->name }}</h1>

                    <div class="detail-location reveal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $item->location }}
                    </div>

                    <div class="detail-body reveal">
                        <h3>Tentang Destinasi</h3>
                        <p>{{ $item->description }}</p>
                        <p>Kawasan ini menawarkan pengalaman wisata yang unik dan tak terlupakan bagi para pengunjung. Dengan keindahan alam yang memukau dan fasilitas yang memadai, destinasi ini menjadi pilihan utama wisatawan lokal maupun mancanegara.</p>
                        <p>Pengunjung dapat menikmati berbagai aktivitas menarik sambil mengenal lebih dekat kekayaan alam dan budaya Delta Brantas. Waktu terbaik untuk mengunjungi adalah pagi hari saat udara masih segar dan cahaya matahari sempurna untuk fotografi.</p>

                        <h3>Fasilitas</h3>
                        <ul class="detail-info-list">
                            <li><strong>Kategori</strong> {{ $category->name }}</li>
                            <li><strong>Lokasi</strong> {{ $item->location }}</li>
                            <li><strong>Rating</strong> {{ $item->rating }} / 5.0</li>
                            <li><strong>Jam Buka</strong> 08.00 - 17.00 WIB</li>
                            <li><strong>Tiket Masuk</strong> Rp 10.000 - Rp 25.000</li>
                        </ul>

                        <h3>Tips Berkunjung</h3>
                        <p>Sebaiknya bawa perlengkapan yang cukup seperti air minum, topi, dan sunscreen. Gunakan alas kaki yang nyaman untuk trekking. Jangan lupa bawa kamera untuk mengabadikan momen indah di destinasi ini.</p>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>{{ $category->name }} Lainnya</h4>
                        @foreach($related as $rel)
                            <a href="/explore/{{ $category->slug }}/{{ $rel->slug }}" class="sidebar-item">
                                <img src="{{ $rel->image }}" alt="{{ $rel->name }}" loading="lazy">
                                <div>
                                    <span>{{ $rel->name }}</span>
                                    <small>{{ $rel->location }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Tertarik Menjelajahi<br>{{ $category->name }} Lainnya?</h2>
                <p>Temukan lebih banyak destinasi {{ strtolower($category->name) }} di Delta Brantas.</p>
                <a href="/explore/{{ $category->slug }}" class="btn-cta">
                    Lihat Semua {{ $category->name }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
