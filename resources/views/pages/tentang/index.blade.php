@extends('layouts.app')

@section('title', 'Tentang - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Mengenal lebih dekat Delta Brantas Sidoarjo, sejarah, visi misi, dan warisan budayanya.')

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        badge="Tentang Kami"
        title='Mengenal Lebih Dekat<br><span class="highlight">Delta Brantas Sidoarjo</span>'
        description="Sebuah kawasan strategis di muara Sungai Brantas yang menyimpan potensi wisata alam, budaya, dan kuliner luar biasa."
        image="images/explore-hero.png"
    />

    {{-- TENTANG DELTA BRANTAS --}}
    <section class="section">
        <div class="container">
            <div class="about-preview-grid reveal">
                <div class="about-preview-content">
                    <span class="section-label">Sejarah</span>
                    <h2 class="section-title">Kota Delta — Sebuah<br>Identitas yang Mengalir</h2>
                    <p class="section-subtitle">Sejak tahun 1859, wilayah Sidoarjo telah menjadi pusat geografis yang strategis di Jawa Timur. Delta Brantas, kawasan di muara Sungai Brantas, menyimpan kekayaan alam dan budaya yang telah mengakar kuat dalam kehidupan masyarakat selama berabad-abad.</p>
                    <p class="section-subtitle">Dari hamparan tambak tradisional hingga hutan mangrove yang lebat, kawasan ini terus berkembang sebagai destinasi wisata yang memadukan keindahan alam dengan warisan budaya yang autentik.</p>

                    <div class="about-stats-row">
                        <div class="about-stat">
                            <span class="about-stat-number">1859</span>
                            <span class="about-stat-label">TAHUN DIDIRIKAN</span>
                        </div>
                        <div class="about-stat">
                            <span class="about-stat-number">714 km²</span>
                            <span class="about-stat-label">LUAS WILAYAH</span>
                        </div>
                    </div>
                </div>
                <div class="about-preview-image reveal reveal-delay-2">
                    <img src="@imgurl('images/jayandaru.jpg')" alt="Monumen Jayandaru Sidoarjo">
                    <blockquote class="about-quote">"Air yang mengalir membawa kehidupan, delta yang menetap menggugah niat."</blockquote>
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
                    <h2>Delta Brantas<br>Dalam Angka</h2>
                    <p>Kawasan Delta Brantas Sidoarjo menyimpan potensi wisata luar biasa dengan beragam destinasi, event tahunan, dan UMKM aktif yang terus berkembang.</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card reveal reveal-delay-1">
                        <div class="stat-number" data-target="48" data-suffix="+">0</div>
                        <div class="stat-label">Destinasi Wisata</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-2">
                        <div class="stat-number" data-target="714" data-suffix=" km²">0</div>
                        <div class="stat-label">Luas Wilayah</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-3">
                        <div class="stat-number" data-target="124" data-suffix="">0</div>
                        <div class="stat-label">Event Budaya</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-4">
                        <div class="stat-number" data-target="350" data-suffix="+">0</div>
                        <div class="stat-label">UMKM Lokal</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="section section-alt">
        <div class="container">
            <div class="vision-section reveal">
                <span class="section-label">Visi & Misi</span>
                <h2 class="section-title">Visi & Misi Kami</h2>
                <blockquote class="vision-quote">
                    "Menjadi destinasi wisata dan pusat ekonomi kreatif berbasis warisan budaya yang mandiri, lestari, dan mendorong pertumbuhan ekonomi berkelanjutan bagi masyarakat Delta Brantas."
                </blockquote>

                <div class="vision-mission-grid">
                    <div class="vision-box">
                        <h3>🎯 Visi</h3>
                        <p>Mewujudkan Delta Brantas sebagai destinasi wisata berkelanjutan yang memadukan keindahan alam, kekayaan budaya, dan inovasi ekonomi kreatif berstandar internasional.</p>
                    </div>
                    <div class="vision-box">
                        <h3>🚀 Misi</h3>
                        <ul class="vision-list">
                            <li>Melestarikan ekosistem alam dan keanekaragaman hayati Delta Brantas</li>
                            <li>Membangun infrastruktur wisata yang ramah lingkungan</li>
                            <li>Memberdayakan masyarakat lokal melalui ekonomi kreatif</li>
                            <li>Mempromosikan budaya dan tradisi lokal ke kancah internasional</li>
                        </ul>
                    </div>
                </div>

                <div class="vision-points">
                    <div class="vision-point">
                        <span class="vision-point-number">1</span>
                        <p>Melestarikan ekosistem alam dan keanekaragaman hayati Delta Brantas untuk generasi mendatang.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">2</span>
                        <p>Membangun infrastruktur wisata yang ramah lingkungan, berkelanjutan, dan aksesibel bagi semua.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">3</span>
                        <p>Memberdayakan masyarakat lokal melalui program ekonomi kreatif dan pelatihan keterampilan.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">4</span>
                        <p>Mempromosikan Delta Brantas sebagai destinasi wisata internasional yang berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HARMONI DI TANAH DELTA --}}
    <section class="section">
        <div class="container">
            <div class="harmoni-grid reveal">
                <div class="harmoni-content">
                    <span class="section-label">Nilai Budaya</span>
                    <h2 class="section-title">Harmoni di Tanah Delta</h2>
                    <p class="section-subtitle">Delta Brantas menyimpan keseimbangan ekologis yang unik antara alam dan kehidupan manusia. Dari hamparan tambak tradisional yang telah diwariskan turun-temurun, hingga situs budaya yang masih aktif, setiap sudutnya menyimpan cerita tentang harmoni antara manusia dan alam.</p>
                    <p class="section-subtitle">Masyarakat Delta Brantas hidup berdampingan dengan alam, menjaga tradisi leluhur sambil membuka diri terhadap perkembangan zaman. Nilai-nilai gotong royong, kelestarian lingkungan, dan kreativitas menjadi fondasi kehidupan sehari-hari.</p>

                    <div class="harmoni-stats">
                        <div class="harmoni-stat">
                            <div class="stat-number" data-target="150" data-suffix="k+">0</div>
                            <div class="stat-label">HEKTAR TAMBAK</div>
                        </div>
                        <div class="harmoni-stat">
                            <div class="stat-number" data-target="350" data-suffix="+">0</div>
                            <div class="stat-label">SITUS BUDAYA</div>
                        </div>
                    </div>
                </div>
                <div class="harmoni-image reveal reveal-delay-2">
                    <img src="{{ asset('images/fotokitablur/brantas.png') }}" alt="Harmoni Delta Brantas">
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
                <a href="/explore" class="btn-cta">
                    Mulai Jelajahi Sidoarjo
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
