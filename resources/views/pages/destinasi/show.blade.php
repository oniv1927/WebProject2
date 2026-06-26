@extends('layouts.app')

@section('title', $destination['title'] . ' - Portal Wisata Delta Brantas')
@section('meta_description', $destination['description'])

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        :badge="$destination['badge']"
        :title="$destination['title']"
        :description="$destination['location']"
        :image="$destination['image']"
        :buttons="[
            ['url' => '/destinasi', 'label' => 'Kembali ke Destinasi', 'style' => 'btn-outline', 'icon' => '<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'18\' height=\'18\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M19 12H5\'/><path d=\'m12 19-7-7 7-7\'/></svg>'],
        ]"
    />

    {{-- DETAIL CONTENT --}}
    <section class="section">
        <div class="container">
            <div class="detail-layout">
                {{-- Main Content --}}
                <div class="detail-main">
                    <div class="detail-hero-image reveal">
                        <img src="@imgurl($destination['image'])" alt="{{ $destination['title'] }}">
                    </div>

                    <div class="detail-content reveal">
                        <div class="detail-meta">
                            <span class="detail-badge">{{ $destination['badge'] }}</span>
                            <div class="detail-rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#fbbf24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>{{ $destination['rating'] }}</span>
                            </div>
                        </div>

                        <h2 class="detail-title">{{ $destination['title'] }}</h2>

                        <div class="detail-location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $destination['location'] }}
                        </div>

                        <div class="detail-body">
                            <p>{{ $destination['description'] }}</p>
                            <p>Kawasan ini menawarkan pengalaman wisata yang unik dan tak terlupakan. Dengan keindahan alam yang memukau, pengunjung dapat menikmati berbagai aktivitas seperti trekking, fotografi alam, dan edukasi lingkungan.</p>
                            <p>Fasilitas yang tersedia meliputi area parkir, mushola, warung makan, toilet, dan jalur pejalan kaki yang terawat. Pengunjung juga dapat menyewa pemandu wisata lokal untuk pengalaman yang lebih mendalam.</p>

                            <h3>Informasi Praktis</h3>
                            <ul class="detail-info-list">
                                <li><strong>Jam Buka:</strong> 08.00 - 17.00 WIB</li>
                                <li><strong>Tiket Masuk:</strong> Rp 10.000 - Rp 25.000</li>
                                <li><strong>Fasilitas:</strong> Parkir, Mushola, Toilet, Warung Makan</li>
                                <li><strong>Aktivitas:</strong> Trekking, Fotografi, Edukasi Alam</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="detail-sidebar">
                    <div class="sidebar-card reveal">
                        <h4>Destinasi Lainnya</h4>
                        @foreach($relatedDestinations as $related)
                            <a href="/destinasi/{{ $related['slug'] }}" class="sidebar-item">
                                <img src="@imgurl($related['image'])" alt="{{ $related['title'] }}">
                                <div>
                                    <span>{{ $related['title'] }}</span>
                                    <small>{{ $related['location'] }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
