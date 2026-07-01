@extends('layouts.app')

@section('title', 'Peta Interaktif - Portal Wisata & Budaya Delta Brantas Sidoarjo')
@section('meta_description', 'Temukan lokasi wisata alam, budaya, dan kuliner khas Sidoarjo di peta interaktif Delta Brantas.')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* ── MAP PAGE STYLES ── */
.peta-section { padding: 60px 0 80px; }

.map-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    margin-top: 40px;
    align-items: start;
}

/* Sidebar */
.map-sidebar {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 20px;
    padding: 24px;
    position: sticky;
    top: 100px;
    max-height: calc(100vh - 140px);
    overflow-y: auto;
}
.map-sidebar::-webkit-scrollbar { width: 4px; }
.map-sidebar::-webkit-scrollbar-track { background: transparent; }
.map-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }

.map-sidebar h4 {
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--color-primary);
    margin: 0 0 14px;
}
.map-sidebar h4:not(:first-child) { margin-top: 24px; }

/* Filter chips */
.map-filter-list { display: flex; flex-direction: column; gap: 8px; }
.map-filter-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 12px;
    cursor: pointer;
    transition: all .2s;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.06);
    color: #94a3b8;
    font-size: .875rem;
    user-select: none;
}
.map-filter-item:hover { background: rgba(255,255,255,.07); color: #fff; }
.map-filter-item.active { background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.3); color: #4ade80; }
.map-filter-item input { display: none; }
.map-filter-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.dot-alam    { background: #4ade80; }
.dot-budaya  { background: #60a5fa; }
.dot-kuliner { background: #fb923c; }

/* Location list */
.map-locations-list { display: flex; flex-direction: column; gap: 6px; }
.map-location-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 12px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.06);
    text-decoration: none;
    transition: all .2s;
    cursor: pointer;
}
.map-location-item:hover { background: rgba(255,255,255,.07); transform: translateX(4px); }
.map-location-icon { font-size: 1.1rem; flex-shrink: 0; width: 28px; text-align: center; }
.map-location-item span { font-size: .82rem; font-weight: 600; color: #e2e8f0; display: block; }
.map-location-item small { font-size: .72rem; color: #64748b; }

/* Map container */
.map-main { border-radius: 20px; overflow: hidden; }
.map-container {
    width: 100%;
    height: 600px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,.08);
    overflow: hidden;
    position: relative;
}
#leaflet-map { width: 100%; height: 100%; }

/* Map count badge */
.map-count-badge {
    display: flex;
    gap: 16px;
    margin-top: 14px;
    flex-wrap: wrap;
}
.map-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .8rem;
    color: #94a3b8;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    padding: 6px 14px;
    border-radius: 100px;
}
.map-badge .dot { width: 8px; height: 8px; border-radius: 50%; }

/* Leaflet popup custom */
.leaflet-popup-content-wrapper {
    background: #111c31 !important;
    border: 1px solid rgba(255,255,255,.12) !important;
    border-radius: 14px !important;
    box-shadow: 0 20px 60px rgba(0,0,0,.5) !important;
    color: #e2e8f0 !important;
    min-width: 220px;
}
.leaflet-popup-tip { background: #111c31 !important; }
.leaflet-popup-close-button { color: #94a3b8 !important; font-size: 18px !important; top: 8px !important; right: 10px !important; }
.popup-title { font-size: .95rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.popup-cat {
    font-size: .72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 2px 8px;
    border-radius: 100px;
    display: inline-block;
    margin-bottom: 8px;
}
.popup-cat.alam    { background: rgba(74,222,128,.15); color: #4ade80; }
.popup-cat.budaya  { background: rgba(96,165,250,.15); color: #60a5fa; }
.popup-cat.kuliner { background: rgba(251,146,60,.15); color: #fb923c; }
.popup-desc { font-size: .8rem; color: #94a3b8; line-height: 1.5; margin-bottom: 8px; }
.popup-alamat { font-size: .75rem; color: #64748b; display: flex; gap: 5px; align-items: flex-start; }

/* Responsive */
@media (max-width: 900px) {
    .map-layout { grid-template-columns: 1fr; }
    .map-sidebar { position: static; max-height: none; }
    .map-container { height: 450px; }
}
</style>
@endpush

@section('content')

    <x-hero
        :compact="true"
        badge="Peta Interaktif"
        title='Temukan <span class="highlight">Petualanganmu</span><br>Selanjutnya'
        description="Eksplorasi lokasi wisata, kuliner, dan budaya nyata di Sidoarjo melalui peta interaktif Delta Brantas."
        image="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop"
    />

    {{-- MAP SECTION --}}
    <section class="section peta-section">
        <div class="container">
            <div class="reveal">
                <span class="section-label">Peta</span>
                <h2 class="section-title">Peta Interaktif Eksplorasi Delta</h2>
                <p class="section-subtitle">Klik marker di peta untuk melihat detail lokasi wisata, kuliner, dan budaya khas Sidoarjo.</p>
            </div>

            <div class="map-layout">
                {{-- Sidebar --}}
                <div class="map-sidebar reveal">
                    <h4>Filter Kategori</h4>
                    <div class="map-filter-list">
                        <label class="map-filter-item active" id="filter-alam" onclick="toggleFilter('alam')">
                            <span class="map-filter-dot dot-alam"></span>
                            <span>🌿 Wisata Alam</span>
                        </label>
                        <label class="map-filter-item active" id="filter-budaya" onclick="toggleFilter('budaya')">
                            <span class="map-filter-dot dot-budaya"></span>
                            <span>🏛️ Situs Budaya</span>
                        </label>
                        <label class="map-filter-item active" id="filter-kuliner" onclick="toggleFilter('kuliner')">
                            <span class="map-filter-dot dot-kuliner"></span>
                            <span>🍜 Kuliner</span>
                        </label>
                    </div>

                    <h4>Lokasi Populer</h4>
                    <div class="map-locations-list">
                        @foreach($popularLocations as $loc)
                            <div class="map-location-item" onclick="focusLocation('{{ $loc['title'] }}')">
                                <div class="map-location-icon">{{ $loc['icon'] }}</div>
                                <div>
                                    <span>{{ $loc['title'] }}</span>
                                    <small>{{ $loc['category'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Map --}}
                <div class="map-main reveal">
                    <div class="map-container">
                        <div id="leaflet-map"></div>
                    </div>
                    <div class="map-count-badge">
                        <div class="map-badge"><span class="dot" style="background:#4ade80"></span> {{ collect($locations)->where('category','alam')->count() }} Wisata Alam</div>
                        <div class="map-badge"><span class="dot" style="background:#60a5fa"></span> {{ collect($locations)->where('category','budaya')->count() }} Budaya & Sejarah</div>
                        <div class="map-badge"><span class="dot" style="background:#fb923c"></span> {{ collect($locations)->where('category','kuliner')->count() }} Kuliner</div>
                    </div>
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
                    <h2>Kawasan Delta Brantas<br>Dalam Angka</h2>
                    <p>Delta Brantas Sidoarjo menyimpan potensi wisata yang luar biasa dengan beragam destinasi, event, dan UMKM aktif.</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card reveal reveal-delay-1">
                        <div class="stat-number" data-target="48" data-suffix="+">0</div>
                        <div class="stat-label">Destinasi Wisata</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-2">
                        <div class="stat-number" data-target="124" data-suffix="">0</div>
                        <div class="stat-label">Event Tahunan</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-3">
                        <div class="stat-number" data-target="350" data-suffix="+">0</div>
                        <div class="stat-label">UMKM Aktif</div>
                    </div>
                    <div class="stat-card reveal reveal-delay-4">
                        <div class="stat-number" data-target="748" data-suffix=" km²">0</div>
                        <div class="stat-label">Luas Kawasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// ── DATA LOKASI DARI CONTROLLER ──
const locations = @json($locations);

// ── INISIALISASI PETA ──
const map = L.map('leaflet-map', {
    center: [-7.4756, 112.7483],
    zoom: 12,
    zoomControl: true,
    attributionControl: true,
}).setView([-7.4756, 112.7483], 12);

// Tile layer (OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
}).addTo(map);

// ── CUSTOM MARKER ICONS ──
function makeIcon(color, emoji) {
    return L.divIcon({
        className: '',
        html: `<div style="
            width:38px;height:38px;border-radius:50% 50% 50% 0;
            background:${color};border:3px solid #fff;
            transform:rotate(-45deg);box-shadow:0 4px 12px rgba(0,0,0,.4);
            display:flex;align-items:center;justify-content:center;
        "><span style="transform:rotate(45deg);font-size:14px;">${emoji}</span></div>`,
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -40],
    });
}

const icons = {
    alam:    makeIcon('#22c55e', '🌿'),
    budaya:  makeIcon('#3b82f6', '🏛️'),
    kuliner: makeIcon('#f97316', '🍜'),
};

// ── BUAT MARKERS ──
const markers = {};
const markerLayer = { alam: [], budaya: [], kuliner: [] };

locations.forEach(loc => {
    const catLabel = loc.category === 'alam' ? 'Wisata Alam' : loc.category === 'budaya' ? 'Budaya & Sejarah' : 'Kuliner';
    const marker = L.marker([loc.lat, loc.lng], { icon: icons[loc.category] })
        .bindPopup(`
            <div style="padding:4px 2px;">
                <div class="popup-title">${loc.icon} ${loc.title}</div>
                <span class="popup-cat ${loc.category}">${catLabel}</span>
                <div class="popup-desc">${loc.desc}</div>
                <div class="popup-alamat">📍 <span>${loc.alamat}</span></div>
            </div>
        `, { maxWidth: 260 })
        .addTo(map);

    markers[loc.title] = marker;
    markerLayer[loc.category].push(marker);
});

// ── FILTER TOGGLE ──
const activeFilters = { alam: true, budaya: true, kuliner: true };

function toggleFilter(cat) {
    activeFilters[cat] = !activeFilters[cat];
    const el = document.getElementById('filter-' + cat);
    el.classList.toggle('active', activeFilters[cat]);

    markerLayer[cat].forEach(m => {
        if (activeFilters[cat]) map.addLayer(m);
        else map.removeLayer(m);
    });
}

// ── FOCUS LOCATION ──
function focusLocation(title) {
    const marker = markers[title];
    if (marker) {
        map.flyTo(marker.getLatLng(), 16, { duration: 1.2 });
        setTimeout(() => marker.openPopup(), 1300);
    }
}
</script>
@endpush
