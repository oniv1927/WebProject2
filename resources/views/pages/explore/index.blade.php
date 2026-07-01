@extends('layouts.app')

@section('title', 'Explore - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Jelajahi semua kategori wisata di Delta Brantas: wisata alam, kuliner, budaya, dan sejarah.')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.explore-map-wrap {
    margin-top: 32px;
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 20px;
    align-items: start;
}
.explore-map-sidebar {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px;
    padding: 20px;
    position: sticky;
    top: 90px;
}
.explore-map-sidebar h5 {
    font-size: .75rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--color-primary); margin: 0 0 12px;
}
.explore-map-sidebar h5:not(:first-child) { margin-top: 20px; }
.explore-filter-list { display: flex; flex-direction: column; gap: 6px; }
.explore-filter-chip {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 10px; cursor: pointer;
    font-size: .82rem; color: #94a3b8; user-select: none;
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.06);
    transition: all .2s;
}
.explore-filter-chip:hover { background: rgba(255,255,255,.07); color: #fff; }
.explore-filter-chip.active { background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.3); color: #4ade80; }
.filter-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dot-alam { background: #4ade80; }
.dot-budaya { background: #60a5fa; }
.dot-kuliner { background: #fb923c; }
.explore-loc-list { display: flex; flex-direction: column; gap: 5px; max-height: 260px; overflow-y: auto; }
.explore-loc-list::-webkit-scrollbar { width: 3px; }
.explore-loc-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 3px; }
.explore-loc-item {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 10px; border-radius: 10px; cursor: pointer;
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.05);
    transition: all .2s;
}
.explore-loc-item:hover { background: rgba(255,255,255,.07); transform: translateX(3px); }
.explore-loc-item span { font-size: .78rem; font-weight: 600; color: #e2e8f0; display: block; }
.explore-loc-item small { font-size: .68rem; color: #64748b; }
.explore-loc-icon { font-size: 1rem; width: 24px; text-align: center; flex-shrink: 0; }
#explore-leaflet-map {
    width: 100%; height: 520px; border-radius: 16px;
    border: 1px solid rgba(255,255,255,.08);
}
.leaflet-popup-content-wrapper {
    background: #111c31 !important; border: 1px solid rgba(255,255,255,.12) !important;
    border-radius: 12px !important; box-shadow: 0 20px 50px rgba(0,0,0,.5) !important;
    color: #e2e8f0 !important; min-width: 200px;
}
.leaflet-popup-tip { background: #111c31 !important; }
.leaflet-popup-close-button { color: #94a3b8 !important; }
.ep-title { font-size: .9rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.ep-cat {
    font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
    padding: 2px 8px; border-radius: 100px; display: inline-block; margin-bottom: 6px;
}
.ep-cat.alam    { background: rgba(74,222,128,.15); color: #4ade80; }
.ep-cat.budaya  { background: rgba(96,165,250,.15); color: #60a5fa; }
.ep-cat.kuliner { background: rgba(251,146,60,.15);  color: #fb923c; }
.ep-desc { font-size: .78rem; color: #94a3b8; line-height: 1.5; margin-bottom: 6px; }
.ep-addr { font-size: .72rem; color: #64748b; }
.map-count-strip { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px; }
.map-count-badge {
    display: flex; align-items: center; gap: 7px; font-size: .78rem; color: #94a3b8;
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.07);
    padding: 5px 12px; border-radius: 100px;
}
.map-count-badge .cdot { width: 7px; height: 7px; border-radius: 50%; }
@media(max-width:860px){
    .explore-map-wrap { grid-template-columns: 1fr; }
    .explore-map-sidebar { position: static; }
    #explore-leaflet-map { height: 400px; }
}
</style>
@endpush

@section('content')

    {{-- HERO --}}
    <x-hero
        :compact="true"
        badge="Explore"
        title='Jelajahi Keajaiban<br><span class="highlight">Delta Brantas</span>'
        description="Temukan pengalaman wisata yang sesuai dengan minat Anda. Dari alam yang memukau hingga budaya yang kaya."
        image="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- CATEGORY FILTER PILLS --}}
    <section class="section explore-filter-section">
        <div class="container">
            <div class="explore-filter-pills reveal">
                <a href="/explore" class="explore-pill active">Semua</a>
                <a href="/explore/wisata-alam" class="explore-pill">Wisata Alam</a>
                <a href="/explore/kuliner" class="explore-pill">Kuliner</a>
                <a href="/explore/budaya-sejarah" class="explore-pill">Budaya & Sejarah</a>
            </div>

            {{-- EXPLORE CATEGORY CARDS --}}
            <div class="explore-category-grid" style="margin-top: 48px;">
                @php
                    $alamCat    = $categories->firstWhere('slug', 'wisata-alam');
                    $kulinerCat = $categories->firstWhere('slug', 'kuliner');
                    $budayaCat  = $categories->firstWhere('slug', 'budaya');
                @endphp
                @if($alamCat)
                    <a href="/explore/wisata-alam" class="explore-category-card reveal reveal-delay-1">
                        <div class="explore-category-image">
                            <img src="@imgurl($alamCat->image)" alt="{{ $alamCat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $alamCat->destinations_count ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $alamCat->icon }}</span>
                            <h3>{{ $alamCat->name }}</h3>
                            <p>{{ $alamCat->description }}</p>
                            <span class="explore-category-link">Jelajahi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
                        </div>
                    </a>
                @endif
                @if($kulinerCat)
                    <a href="/explore/kuliner" class="explore-category-card reveal reveal-delay-2">
                        <div class="explore-category-image">
                            <img src="@imgurl($kulinerCat->image)" alt="{{ $kulinerCat->name }}" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $kulinerCat->destinations_count ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">{{ $kulinerCat->icon }}</span>
                            <h3>{{ $kulinerCat->name }}</h3>
                            <p>{{ $kulinerCat->description }}</p>
                            <span class="explore-category-link">Jelajahi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
                        </div>
                    </a>
                @endif
                @if($budayaCat)
                    <a href="/explore/budaya-sejarah" class="explore-category-card reveal reveal-delay-3">
                        <div class="explore-category-image">
                            <img src="@imgurl($budayaCat->image)" alt="Budaya & Sejarah" loading="lazy">
                            <div class="explore-category-overlay"></div>
                            <span class="explore-category-count">{{ $budayaSejarahCount ?? 0 }} Destinasi</span>
                        </div>
                        <div class="explore-category-body">
                            <span class="explore-category-icon">🏛️</span>
                            <h3>Budaya & Sejarah</h3>
                            <p>Jelajahi warisan budaya dan situs bersejarah Delta Brantas.</p>
                            <span class="explore-category-link">Jelajahi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- INTERACTIVE MAP SECTION --}}
    <section class="section section-alt">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Peta</span>
                <h2 class="section-title">Peta Interaktif<br>Eksplorasi Delta</h2>
                <p class="section-subtitle">Klik marker untuk melihat detail lokasi wisata, kuliner, dan budaya khas Sidoarjo.</p>
            </div>

            <div class="explore-map-wrap reveal">
                {{-- Sidebar --}}
                <div class="explore-map-sidebar">
                    <h5>Filter</h5>
                    <div class="explore-filter-list">
                        <div class="explore-filter-chip active" id="efChip-alam" onclick="toggleExploreFilter('alam')">
                            <span class="filter-dot dot-alam"></span> 🌿 Wisata Alam
                        </div>
                        <div class="explore-filter-chip active" id="efChip-budaya" onclick="toggleExploreFilter('budaya')">
                            <span class="filter-dot dot-budaya"></span> 🏛️ Budaya
                        </div>
                        <div class="explore-filter-chip active" id="efChip-kuliner" onclick="toggleExploreFilter('kuliner')">
                            <span class="filter-dot dot-kuliner"></span> 🍜 Kuliner
                        </div>
                    </div>

                    <h5>Lokasi Populer</h5>
                    <div class="explore-loc-list">
                        @foreach($mapLocations as $loc)
                            <div class="explore-loc-item" onclick="flyToMarker('{{ addslashes($loc['title']) }}')">
                                <div class="explore-loc-icon">{{ $loc['icon'] }}</div>
                                <div>
                                    <span>{{ $loc['title'] }}</span>
                                    <small>{{ $loc['category'] === 'alam' ? 'Wisata Alam' : ($loc['category'] === 'budaya' ? 'Budaya' : 'Kuliner') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Map --}}
                <div>
                    <div id="explore-leaflet-map"></div>
                    <div class="map-count-strip">
                        <div class="map-count-badge"><span class="cdot" style="background:#4ade80"></span> {{ collect($mapLocations)->where('category','alam')->count() }} Wisata Alam</div>
                        <div class="map-count-badge"><span class="cdot" style="background:#60a5fa"></span> {{ collect($mapLocations)->where('category','budaya')->count() }} Budaya & Sejarah</div>
                        <div class="map-count-badge"><span class="cdot" style="background:#fb923c"></span> {{ collect($mapLocations)->where('category','kuliner')->count() }} Kuliner</div>
                    </div>
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
                <a href="/explore/wisata-alam" class="btn-cta">
                    Mulai Jelajahi
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const exploreLocations = @json($mapLocations);

const eMap = L.map('explore-leaflet-map', {
    zoomControl: false
}).setView([-7.4756, 112.7483], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19
}).addTo(eMap);

function eIcon(color, emoji) {
    return L.divIcon({
        className: '',
        html: `<div style="width:36px;height:36px;border-radius:50% 50% 50% 0;background:${color};border:3px solid #fff;transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:13px;">${emoji}</span></div>`,
        iconSize: [36,36], iconAnchor: [18,36], popupAnchor: [0,-38]
    });
}
const eIcons = {
    alam:    eIcon('#22c55e','🌿'),
    budaya:  eIcon('#3b82f6','🏛️'),
    kuliner: eIcon('#f97316','🍜'),
};

const eMarkers = {};
const eLayerGroups = { alam: [], budaya: [], kuliner: [] };
const eFilters    = { alam: true, budaya: true, kuliner: true };

exploreLocations.forEach(loc => {
    const catLabel = loc.category === 'alam' ? 'Wisata Alam' : loc.category === 'budaya' ? 'Budaya & Sejarah' : 'Kuliner';
    const m = L.marker([loc.lat, loc.lng], { icon: eIcons[loc.category] })
        .bindPopup(`<div style="padding:2px"><div class="ep-title">${loc.icon} ${loc.title}</div><span class="ep-cat ${loc.category}">${catLabel}</span><div class="ep-desc">${loc.desc}</div><div class="ep-addr">📍 ${loc.alamat}</div></div>`, { maxWidth: 250 })
        .addTo(eMap);
    eMarkers[loc.title] = m;
    eLayerGroups[loc.category].push(m);
});

function toggleExploreFilter(cat) {
    eFilters[cat] = !eFilters[cat];
    document.getElementById('efChip-' + cat).classList.toggle('active', eFilters[cat]);
    eLayerGroups[cat].forEach(m => eFilters[cat] ? eMap.addLayer(m) : eMap.removeLayer(m));
}

function flyToMarker(title) {
    const m = eMarkers[title];
    if (m) {
        eMap.flyTo(m.getLatLng(), 16, { duration: 1.2 });
        setTimeout(() => m.openPopup(), 1300);
    }
}
</script>
@endpush
