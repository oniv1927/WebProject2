@extends('layouts.app')

@section('title', $article['title'] . ' - Artikel Delta Brantas')
@section('meta_description', $article['excerpt'])

@section('content')

    <x-hero
        :compact="true"
        badge="Artikel"
        :title="$article['title']"
        :description="$article['date'] . ' • 5 menit baca'"
        :image="$article['image']"
        :buttons="[
            ['url' => '/artikel', 'label' => 'Kembali ke Artikel', 'style' => 'btn-outline', 'icon' => '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M19 12H5\'/><path d=\'m12 19-7-7 7-7\'/></svg>'],
        ]"
    />

    <section class="section">
        <div class="container">
            <div class="detail-layout">
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                    </div>

                    <div class="detail-content reveal">
                        <div class="detail-meta">
                            <span class="detail-badge">{{ $article['date'] }}</span>
                            <span class="detail-badge">5 menit baca</span>
                        </div>

                        <h2 class="detail-title">{{ $article['title'] }}</h2>

                        <div class="detail-body">
                            <p>{{ $article['excerpt'] }}</p>
                            <p>Delta Brantas Sidoarjo terus menunjukkan perkembangan signifikan dalam sektor pariwisata. Berbagai program inovasi telah diluncurkan untuk meningkatkan daya tarik kawasan ini sebagai destinasi wisata unggulan di Jawa Timur.</p>
                            <p>Menurut Kepala Dinas Kebudayaan dan Pariwisata Kabupaten Sidoarjo, peningkatan kunjungan wisatawan mencapai 25% dibandingkan tahun sebelumnya. Hal ini didorong oleh berbagai event budaya, perbaikan infrastruktur, dan promosi digital yang masif.</p>

                            <h3>Dampak Ekonomi</h3>
                            <p>Program revitalisasi kawasan wisata tidak hanya berdampak pada peningkatan kunjungan, tetapi juga mendorong pertumbuhan UMKM di sekitar lokasi wisata. Para pelaku usaha lokal melaporkan peningkatan pendapatan hingga 40% sejak program ini berjalan.</p>
                            <p>Kolaborasi antara pemerintah daerah, komunitas lokal, dan pihak swasta menjadi kunci keberhasilan program ini. Ke depan, berbagai program lanjutan sudah disiapkan untuk mempertahankan momentum positif ini.</p>

                            <h3>Rencana ke Depan</h3>
                            <p>Beberapa proyek pengembangan sedang dalam tahap perencanaan, termasuk pembangunan jalur sepeda wisata, pusat informasi digital, dan area kuliner terpadu. Semua proyek ini ditargetkan selesai pada akhir tahun depan.</p>
                        </div>
                    </div>
                </div>

                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>Artikel Lainnya</h4>
                        @foreach($relatedArticles as $related)
                            <a href="/artikel/{{ $related['slug'] }}" class="sidebar-item">
                                <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}">
                                <div>
                                    <span>{{ $related['title'] }}</span>
                                    <small>{{ $related['date'] }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
