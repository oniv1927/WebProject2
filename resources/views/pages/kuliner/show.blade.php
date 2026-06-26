@extends('layouts.app')

@section('title', $food['title'] . ' - Kuliner Khas Delta Brantas')
@section('meta_description', $food['description'])

@section('content')

    <x-hero
        :compact="true"
        badge="Kuliner"
        :title="$food['title']"
        :description="$food['description']"
        :image="$food['image']"
        :buttons="[
            ['url' => '/kuliner', 'label' => 'Kembali ke Kuliner', 'style' => 'btn-outline', 'icon' => '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M19 12H5\'/><path d=\'m12 19-7-7 7-7\'/></svg>'],
        ]"
    />

    <section class="section">
        <div class="container">
            <div class="detail-layout">
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="@imgurl($food['image'])" alt="{{ $food['title'] }}">
                    </div>

                    <div class="detail-content reveal">
                        <div class="detail-meta">
                            <span class="detail-badge">Kuliner Khas</span>
                        </div>

                        <h2 class="detail-title">{{ $food['title'] }}</h2>

                        <div class="detail-body">
                            <p>{{ $food['description'] }}</p>
                            <p>Hidangan ini telah menjadi bagian dari kehidupan masyarakat Sidoarjo selama puluhan tahun. Resepnya diwariskan turun-temurun dan menjadi kebanggaan kuliner kota Sidoarjo.</p>
                            <p>Bahan-bahan yang digunakan semuanya segar dan lokal, menghasilkan cita rasa yang khas dan tidak bisa ditemukan di tempat lain. Setiap gigitan menghadirkan kelezatan yang membuat ketagihan.</p>

                            <h3>Informasi Kuliner</h3>
                            <ul class="detail-info-list">
                                <li><strong>Harga:</strong> Rp 10.000 - Rp 35.000</li>
                                <li><strong>Ketersediaan:</strong> Sepanjang Hari</li>
                                <li><strong>Jenis:</strong> Makanan Tradisional</li>
                                <li><strong>Level Pedas:</strong> Bisa disesuaikan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>Kuliner Lainnya</h4>
                        @foreach($relatedFoods as $related)
                            <a href="/kuliner/{{ $related['slug'] }}" class="sidebar-item">
                                <img src="@imgurl($related['image'])" alt="{{ $related['title'] }}">
                                <div>
                                    <span>{{ $related['title'] }}</span>
                                    <small>Kuliner Khas</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
