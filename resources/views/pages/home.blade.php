@extends('layouts.app')

@section('title', 'Beranda - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Jelajahi keindahan wisata, budaya, dan kuliner khas kawasan Delta Brantas Sidoarjo.')

@section('content')

    {{-- HERO --}}
    <x-hero
        badge="Portal Wisata & Budaya"
        title='Mengenal Lebih Dekat<br><span class="highlight">Delta Brantas Sidoarjo</span>'
        description="Jelajahi kekayaan alam, budaya, dan kuliner khas kawasan Delta Brantas. Dari hutan mangrove hingga situs bersejarah, temukan pesona yang tak terlupakan."
        image="https://images.unsplash.com/photo-1596402184320-4174ca1817e0?q=80&w=2070&auto=format&fit=crop"
        :buttons="[
            ['url' => '/explore', 'label' => 'Mulai Jelajah', 'style' => 'btn-primary', 'icon' => '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><circle cx=\'11\' cy=\'11\' r=\'8\'/><path d=\'m21 21-4.3-4.3\'/></svg>'],
            ['url' => '/tentang', 'label' => 'Pelajari Selengkapnya', 'style' => 'btn-outline'],
        ]"
    />

    {{-- TENTANG DELTA BRANTAS PREVIEW --}}
    <section class="section">
        <div class="container">
            <div class="about-preview-grid reveal">
                <div class="about-preview-content">
                    <span class="section-label">Tentang</span>
                    <h2 class="section-title">Kota Delta — Sebuah<br>Identitas yang Mengalir</h2>
                    <p class="section-subtitle">Sejak zaman dahulu, wilayah ini telah menjadi pusat geografis yang strategis. Air yang mengalir membawa kehidupan, delta yang menetap menggugah niat untuk terus berkembang.</p>

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

                    <a href="/tentang" class="btn btn-outline" style="margin-top: 24px;">Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="about-preview-image reveal reveal-delay-2">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=800&auto=format&fit=crop" alt="Delta Brantas Sidoarjo">
                    <blockquote class="about-quote">"Air yang mengalir membawa kehidupan, delta yang menetap menggugah niat."</blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- EXPLORE CATEGORIES --}}
    <section class="section section-alt">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Explore</span>
                <h2 class="section-title">Jelajahi Keajaiban<br>Delta Brantas</h2>
                <p class="section-subtitle">Temukan pengalaman wisata yang sesuai dengan minat Anda, dari alam hingga budaya.</p>
            </div>

            <div class="explore-category-grid">
                @foreach($categories as $cat)
                    <a href="/explore/{{ $cat->slug }}" class="explore-category-card reveal reveal-delay-{{ $loop->iteration }}">
                        <div class="explore-category-image">
                            <img src="@imgurl($cat->image)" alt="{{ $cat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $cat->destinations_count }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $cat->icon }}</span>
                            <h3>{{ $cat->name }}</h3>
                            <p>{{ $cat->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- DESTINASI WISATA --}}
    <section class="section" id="section-destinasi">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Destinasi Wisata</span>
                    <h2 class="section-title">{{ count($destinations) > 0 ? $destinations->first()->name : 'Destinasi Wisata' }}</h2>
                </div>
                <p class="section-subtitle">Sekitar 30 menit dari pusat kota Sidoarjo, destinasi ini menawarkan pengalaman alam yang tak terlupakan.</p>
            </div>

            @if(count($destinations) > 0)
                <div class="home-desti-grid reveal">
                    @foreach($destinations as $dest)
                        <a href="/explore/{{ $dest->category->slug }}/{{ $dest->slug }}" class="home-desti-card">
                            <div class="destination-card-image" style="height: 200px; overflow: hidden; position: relative;">
                                <img src="@imgurl($dest->image)" alt="{{ $dest->name }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(17,28,49,1) 0%, transparent 100%);"></div>
                                @if($dest->badge)
                                    <span class="card-badge" style="position: absolute; top: 12px; right: 12px; background: #22c55e; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">{{ $dest->badge }}</span>
                                @endif
                            </div>
                            <div class="home-desti-card-body">
                                <h4>{{ $dest->name }}</h4>
                                <div class="home-desti-card-meta">
                                    <span>📍 {{ $dest->location }}</span>
                                    <span class="rating">⭐ {{ $dest->rating }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding: 60px 20px; color: #64748b;">
                    <div style="font-size:3rem; margin-bottom:12px;">🌿</div>
                    <p style="font-size:1rem;">Belum ada destinasi aktif.<br>Tambahkan melalui <a href="/admin" style="color:#22c55e;">Dashboard Admin</a>.</p>
                </div>
            @endif

            <div class="section-more reveal">
                <a href="/explore/wisata-alam" class="btn btn-outline">Lihat Semua Wisata Alam
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- VISI & MISI PREVIEW --}}
    <section class="section section-alt">
        <div class="container">
            <div class="vision-preview reveal">
                <span class="section-label">Visi & Misi</span>
                <h2 class="section-title">Visi & Misi Kami</h2>
                <blockquote class="vision-quote">
                    "Menjadi destinasi wisata dan pusat ekonomi kreatif berbasis warisan budaya yang mandiri, lestari, dan mendorong pertumbuhan ekonomi berkelanjutan."
                </blockquote>
                <div class="vision-points">
                    <div class="vision-point">
                        <span class="vision-point-number">1</span>
                        <p>Melestarikan ekosistem alam dan keanekaragaman hayati Delta Brantas.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">2</span>
                        <p>Membangun infrastruktur wisata yang ramah lingkungan dan berkelanjutan.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">3</span>
                        <p>Memberdayakan masyarakat lokal melalui program ekonomi kreatif.</p>
                    </div>
                    <div class="vision-point">
                        <span class="vision-point-number">4</span>
                        <p>Mempromosikan Delta Brantas sebagai destinasi wisata internasional.</p>
                    </div>
                </div>
                <a href="/tentang" class="btn btn-outline" style="margin-top: 32px;">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    {{-- HARMONI DI TANAH DELTA --}}
    <section class="section">
        <div class="container">
            <div class="harmoni-grid reveal">
                <div class="harmoni-content">
                    <span class="section-label">Statistik</span>
                    <h2 class="section-title">Harmoni di Tanah Delta</h2>
                    <p class="section-subtitle">Delta Brantas menyimpan keseimbangan ekologis yang unik antara alam dan kehidupan manusia. Dari hamparan tambak hingga situs budaya, setiap sudutnya menyimpan cerita.</p>

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
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800&auto=format&fit=crop" alt="Harmoni Delta Brantas">
                </div>
            </div>
        </div>
    </section>

    {{-- KULINER KHAS --}}
    <section class="section section-alt" id="section-kuliner">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Kuliner Khas</span>
                    <h2 class="section-title">Cita Rasa Sidoarjo</h2>
                </div>
                <p class="section-subtitle">Nikmati kelezatan kuliner autentik khas Delta Brantas yang melegenda.</p>
            </div>

            @if(count($culinaries) > 0)
                <div class="home-kuliner-grid reveal">
                    @php
                        $icons = ['Makanan' => '🍽️', 'Minuman' => '🥤', 'Camilan' => '🍘', 'Bumbu' => '🫙', 'Oleh-oleh' => '🎁'];
                    @endphp
                    @foreach($culinaries as $k)
                        <div class="home-kuliner-card">
                            <div class="home-kuliner-icon">{{ $icons[$k->category_type] ?? '🍜' }}</div>
                            <div class="home-kuliner-info">
                                <h4>{{ $k->name }}</h4>
                                <span>{{ $k->category_type }}</span>
                                @if($k->description)
                                    <p style="font-size:.8rem;color:#64748b;margin-top:6px;line-height:1.5">{{ Str::limit($k->description, 60) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding: 40px 20px; color: #64748b;">
                    <div style="font-size:2.5rem; margin-bottom:10px;">🍜</div>
                    <p>Belum ada kuliner aktif. Tambahkan melalui <a href="/admin" style="color:#22c55e;">Dashboard Admin</a>.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- BERITA TERBARU --}}
    <section class="section" id="section-berita">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">Berita</span>
                    <h2 class="section-title">Berita Terbaru</h2>
                </div>
                <p class="section-subtitle">Informasi terkini seputar wisata, budaya, dan event di Delta Brantas.</p>
            </div>

            @if(count($articles) > 0)
                <div class="article-grid">
                    @foreach($articles as $article)
                        <div class="dyn-artikel-wrapper reveal reveal-delay-{{ $loop->iteration }}">
                            <div class="dyn-artikel-card">
                                @if($loop->first)
                                    <span class="dyn-badge-new">✨ Terbaru</span>
                                @endif
                                <span class="article-date">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d M Y') }}</span>
                                <h3><a href="/berita/{{ $article->slug }}" style="color: inherit; text-decoration: none;">{{ $article->title }}</a></h3>
                                <p>{{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding: 40px 20px; color: #64748b;">
                    <div style="font-size:2.5rem; margin-bottom:10px;">📰</div>
                    <p>Belum ada artikel publikasi. Tambahkan melalui <a href="/admin" style="color:#22c55e;">Dashboard Admin</a>.</p>
                </div>
            @endif

            <div class="section-more reveal">
                <a href="/berita" class="btn btn-outline">Lihat Semua Berita
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
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

@push('scripts')
<style>
/* ── Home Destinasi Grid ─────────────────── */
.home-desti-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

/* ── Home Kuliner Grid ───────────────────── */
.home-kuliner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

/* ── Kuliner Card ────────────────────────── */
.home-kuliner-card {
    background: #44844d;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all .3s cubic-bezier(.4,0,.2,1);
}
.home-kuliner-card:hover {
    border-color: rgba(34,197,94,.25);
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.3);
}
.home-kuliner-icon {
    font-size: 2.2rem;
    width: 56px;
    height: 56px;
    background: rgba(34,197,94,.08);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.home-kuliner-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}
.home-kuliner-info span {
    font-size: .78rem;
    color: #64748b;
    background: rgba(255,255,255,.05);
    padding: 2px 10px;
    border-radius: 6px;
}

/* ── Home Destinasi Card ─────────────────── */
.home-desti-card {
    background: #111c31;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 20px;
    overflow: hidden;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    display: block;
    text-decoration: none;
}
.home-desti-card:hover {
    border-color: rgba(34,197,94,.25);
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.3);
}
.home-desti-card-body {
    padding: 20px;
}
.home-desti-card-body h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
}
.home-desti-card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .8rem;
    color: #64748b;
    margin-top: 4px;
}
.home-desti-card-meta .rating {
    color: #fbbf24;
    font-weight: 600;
}

/* ── Dynamic artikel card ────────────────── */
.dyn-artikel-card {
    background: #111c31;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 20px;
    padding: 24px;
    transition: all .3s;
    height: 100%;
}
.dyn-artikel-card:hover {
    border-color: rgba(34,197,94,.2);
    transform: translateY(-3px);
}
.dyn-artikel-card .article-date {
    font-size: .75rem;
    color: #22c55e;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 8px;
}
.dyn-artikel-card h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.4;
    margin-bottom: 8px;
}
.dyn-artikel-card p {
    font-size: .85rem;
    color: #64748b;
    line-height: 1.6;
}
.dyn-badge-new {
    display: inline-block;
    background: rgba(34,197,94,.12);
    color: #22c55e;
    font-size: .7rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
    margin-bottom: 10px;
    letter-spacing: .5px;
    text-transform: uppercase;
}
</style>
@endpush
