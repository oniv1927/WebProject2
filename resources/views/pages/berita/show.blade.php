@extends('layouts.app')

@section('title', $article->title . ' - Berita Delta Brantas Sidoarjo')
@section('meta_description', $article->excerpt)

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        badge="Berita"
        :title="$article->title"
        :description="$article->excerpt"
        :image="$article->image"
    />

    {{-- ARTICLE DETAIL --}}
    <section class="section">
        <div class="container">
            <div class="detail-layout">
                {{-- MAIN CONTENT --}}
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="@imgurl($article->image)" alt="{{ $article->title }}">
                    </div>

                    <div class="detail-meta reveal">
                        <span class="detail-badge">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</span>
                    </div>

                    <h1 class="detail-title reveal">{{ $article->title }}</h1>

                    <div class="detail-body reveal">
                        <p><strong>{{ $article->excerpt }}</strong></p>

                        <h3>Detail Berita</h3>
                        {!! $article->content !!}
                        <p>Perkembangan terbaru di kawasan Delta Brantas menunjukkan tren positif dalam peningkatan kualitas wisata dan budaya. Berbagai pihak terus berkolaborasi untuk menghadirkan pengalaman terbaik bagi wisatawan yang berkunjung.</p>
                        <p>Program-program inovatif terus digalakkan untuk mendukung pelestarian alam dan pengembangan ekonomi kreatif masyarakat setempat. Hal ini sejalan dengan visi Delta Brantas sebagai destinasi wisata berkelanjutan.</p>

                        <h3>Dampak Positif</h3>
                        <p>Kegiatan ini berdampak positif pada peningkatan kunjungan wisatawan dan pertumbuhan ekonomi lokal. Masyarakat sekitar juga turut merasakan manfaat dari perkembangan sektor pariwisata di kawasan ini.</p>
                        <p>Diharapkan, inisiatif semacam ini dapat terus berkembang dan menjadi contoh bagi daerah lain dalam mengelola potensi wisata secara berkelanjutan dan bertanggung jawab.</p>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>Berita Terkait</h4>
                        @foreach($related as $rel)
                            <a href="/berita/{{ $rel->slug }}" class="sidebar-item">
                                <img src="@imgurl($rel->image)" alt="{{ $rel->title }}" loading="lazy">
                                <div>
                                    <span>{{ $rel->title }}</span>
                                    <small>{{ \Carbon\Carbon::parse($rel->published_at)->translatedFormat('d M Y') }}</small>
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
                <h2>Jelajahi Keajaiban<br>Delta Brantas</h2>
                <p>Temukan pengalaman wisata tak terlupakan di kawasan Delta Brantas.</p>
                <a href="/explore" class="btn-cta">
                    Mulai Jelajahi
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
