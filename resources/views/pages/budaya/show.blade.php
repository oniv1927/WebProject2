@extends('layouts.app')

@section('title', $culture['title'] . ' - Budaya & Sejarah Delta Brantas')
@section('meta_description', $culture['description'])

@section('content')

    <x-hero
        :compact="true"
        :badge="$culture['category']"
        :title="$culture['title']"
        :description="$culture['description']"
        :image="$culture['image']"
        :buttons="[
            ['url' => '/budaya', 'label' => 'Kembali ke Budaya', 'style' => 'btn-outline', 'icon' => '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M19 12H5\'/><path d=\'m12 19-7-7 7-7\'/></svg>'],
        ]"
    />

    <section class="section">
        <div class="container">
            <div class="detail-layout">
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="@imgurl($culture['image'])" alt="{{ $culture['title'] }}">
                    </div>

                    <div class="detail-content reveal">
                        <div class="detail-meta">
                            <span class="detail-badge">{{ $culture['category'] }}</span>
                        </div>

                        <h2 class="detail-title">{{ $culture['title'] }}</h2>

                        <div class="detail-body">
                            <p>{{ $culture['description'] }}</p>
                            <p>Warisan budaya ini merupakan bagian penting dari identitas masyarakat Sidoarjo. Tradisi dan nilai-nilai yang terkandung di dalamnya telah diwariskan dari generasi ke generasi dan tetap dijaga kelestariannya hingga saat ini.</p>
                            <p>Pengunjung dapat menyaksikan langsung kegiatan budaya ini dan bahkan berpartisipasi dalam beberapa aktivitas yang diselenggarakan oleh komunitas lokal.</p>

                            <h3>Informasi Lengkap</h3>
                            <ul class="detail-info-list">
                                <li><strong>Kategori:</strong> {{ $culture['category'] }}</li>
                                <li><strong>Lokasi:</strong> {{ $culture['location'] ?? 'Sidoarjo, Jawa Timur' }}</li>
                                <li><strong>Waktu Terbaik Berkunjung:</strong> Sepanjang Tahun</li>
                                <li><strong>Aktivitas:</strong> Edukasi Budaya, Fotografi, Workshop</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>Budaya Lainnya</h4>
                        @foreach($relatedCultures as $related)
                            <a href="/budaya/{{ $related['slug'] }}" class="sidebar-item">
                                <img src="@imgurl($related['image'])" alt="{{ $related['title'] }}">
                                <div>
                                    <span>{{ $related['title'] }}</span>
                                    <small>{{ $related['category'] }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
