<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Article;
use App\Models\MapLocation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // ===== PAGE METHODS =====

    public function home()
    {
        $categories = Category::withCount('destinations')->get();
        $destinations = Destination::with('category')
                            ->whereHas('category', function($q) {
                                $q->where('slug', 'wisata-alam');
                            })
                            ->where('status', 'Aktif')
                            ->orderBy('is_featured', 'desc')
                            ->take(3)
                            ->get();

        $articles = Article::where('status', 'Publikasi')->orderBy('published_at', 'desc')->take(3)->get();
        $culinaries = Culinary::where('status', 'Aktif')->take(3)->get();

        // Combined Budaya + Sejarah count for Home category card
        $bsCategoryIds = Category::whereIn('slug', ['budaya', 'sejarah'])->pluck('id');
        $budayaSejarahCount = Destination::whereIn('category_id', $bsCategoryIds)->where('status', 'Aktif')->count();

        return view('pages.home', [
            'categories' => $categories,
            'destinations' => $destinations,
            'articles' => $articles,
            'culinaries' => $culinaries,
            'budayaSejarahCount' => $budayaSejarahCount,
        ]);
    }

    public function exploreIndex()
    {
        $categories = Category::withCount('destinations')->get();
        $allDestinations = Destination::with('category')->where('status', 'Aktif')->get();

        $allCulinary = Culinary::where('status', 'Aktif')->get()->map(function($c) {
            $c->category = (object)['slug' => 'kuliner'];
            return $c;
        });

        $allItems = $allDestinations->concat($allCulinary);

        $bsCategoryIds = Category::whereIn('slug', ['budaya', 'sejarah'])->pluck('id');
        $budayaSejarahCount = Destination::whereIn('category_id', $bsCategoryIds)->where('status', 'Aktif')->count();

        $filterTabs = [
            ['slug' => '', 'name' => 'Semua'],
            ['slug' => 'wisata-alam', 'name' => 'Wisata Alam'],
            ['slug' => 'kuliner', 'name' => 'Kuliner'],
            ['slug' => 'budaya-sejarah', 'name' => 'Budaya & Sejarah'],
        ];

        // ── Data Peta Interaktif ──
        $mapLocations = MapLocation::where('status', 'Aktif')
            ->get()
            ->map(fn($l) => [
                'title'    => $l->name,
                'category' => $l->category,
                'icon'     => $l->icon,
                'lat'      => (float)$l->latitude,
                'lng'      => (float)$l->longitude,
                'desc'     => $l->description ?? '-',
                'alamat'   => $l->address ?? '-',
            ]);

        // Fallback jika kosong
        if ($mapLocations->isEmpty()) {
            $mapLocations = collect([
                ['title' => 'Wisata Bahari Tlocor', 'category' => 'alam',    'icon' => '🌿', 'lat' => -7.5527, 'lng' => 112.8452, 'desc' => 'Ekowisata mangrove dan pulau lumpur di muara Sungai Porong.',  'alamat' => 'Jl. Dermaga Tlocor, Jabon, Sidoarjo'],
                ['title' => 'Pantai Kepetingan',     'category' => 'alam',    'icon' => '🌿', 'lat' => -7.5610, 'lng' => 112.8180, 'desc' => 'Pantai mangrove lebat dengan ekosistem burung bangau.',          'alamat' => 'Desa Sawohan, Buduran, Sidoarjo'],
                ['title' => 'Alun-Alun Sidoarjo',   'category' => 'budaya',  'icon' => '🏛️', 'lat' => -7.4458, 'lng' => 112.7178, 'desc' => 'Pusat kota dan ruang publik ikonik Sidoarjo.',                  'alamat' => 'Jl. Sultan Agung, Sidoarjo'],
                ['title' => 'Monumen Jayandaru',     'category' => 'budaya',  'icon' => '🏛️', 'lat' => -7.4502, 'lng' => 112.7165, 'desc' => 'Monumen kebanggaan Sidoarjo, indah di malam hari.',             'alamat' => 'Jl. Jenggolo, Sidoarjo'],
                ['title' => 'Museum Mpu Tantular',   'category' => 'budaya',  'icon' => '🏛️', 'lat' => -7.4278, 'lng' => 112.7235, 'desc' => 'Museum sejarah Jawa Timur dengan koleksi arkeologi.',           'alamat' => 'Jl. Raya Buduran, Sidoarjo'],
                ['title' => 'Kampung Batik Jetis',   'category' => 'budaya',  'icon' => '🏛️', 'lat' => -7.4525, 'lng' => 112.7212, 'desc' => 'Sentra batik tulis khas Sidoarjo.',                             'alamat' => 'Jl. P. Diponegoro, Sidoarjo'],
                ['title' => 'Candi Pari',             'category' => 'budaya',  'icon' => '🏛️', 'lat' => -7.5505, 'lng' => 112.7230, 'desc' => 'Candi Hindu peninggalan Majapahit abad ke-14.',                 'alamat' => 'Desa Candi Pari, Porong, Sidoarjo'],
                ['title' => 'Sentra Kupang Lontong', 'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4620, 'lng' => 112.7090, 'desc' => 'Pusat kuliner lontong kupang otentik khas Sidoarjo.',           'alamat' => 'Pasar Larangan, Candi, Sidoarjo'],
                ['title' => 'Rawon Gajah Mada',      'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4480, 'lng' => 112.7150, 'desc' => 'Rawon legendaris cita rasa khas Sidoarjo.',                     'alamat' => 'Jl. Gajah Mada, Sidoarjo'],
                ['title' => 'Pazkul Sidoarjo',       'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4385, 'lng' => 112.7460, 'desc' => 'Food court modern dengan ratusan pilihan kuliner lokal.',       'alamat' => 'Jl. Jati, Kahuripan Nirwana, Sidoarjo'],
                ['title' => 'Sentra Bandeng Asap',   'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4466, 'lng' => 112.7310, 'desc' => 'Pusat oleh-oleh bandeng asap dan presto khas Sidoarjo.',       'alamat' => 'Jl. Raya Sidoarjo–Surabaya'],
            ]);
        }

        return view('pages.explore.index', [
            'categories'        => $categories,
            'allItems'          => $allItems,
            'budayaSejarahCount'=> $budayaSejarahCount,
            'filterTabs'        => $filterTabs,
            'mapLocations'      => $mapLocations->values()->toArray(),
        ]);
    }

    public function exploreCategory($category_slug)
    {
        $categories = Category::all();

        // Filter tabs (consistent across all explore pages)
        $filterTabs = [
            ['slug' => '', 'name' => 'Semua'],
            ['slug' => 'wisata-alam', 'name' => 'Wisata Alam'],
            ['slug' => 'kuliner', 'name' => 'Kuliner'],
            ['slug' => 'budaya-sejarah', 'name' => 'Budaya & Sejarah'],
        ];

        if ($category_slug === 'kuliner') {
            $category = Category::where('slug', 'kuliner')->first();
            if (!$category) {
                $category = (object)[
                    'name' => 'Wisata Kuliner',
                    'slug' => 'kuliner',
                    'icon' => '🍲',
                    'description' => 'Eksplorasi kuliner khas Delta Brantas.',
                    'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070'
                ];
            }
            $featured = Culinary::where('status', 'Aktif')->where('is_featured', 1)->first();
            $regularItemsQuery = Culinary::where('status', 'Aktif');
            if ($featured) {
                $regularItemsQuery->where('id', '!=', $featured->id);
            }
            $regularItems = $regularItemsQuery->get()->map(function($c) {
                $c->category = (object)['slug' => 'kuliner'];
                return $c;
            });
            if ($featured) {
                 $featured->category = (object)['slug' => 'kuliner'];
            }
        } elseif ($category_slug === 'budaya-sejarah') {
            // Combined Budaya & Sejarah
            $budayaCat = Category::where('slug', 'budaya')->first();
            $sejarahCat = Category::where('slug', 'sejarah')->first();
            $categoryIds = collect([$budayaCat, $sejarahCat])->filter()->pluck('id');

            $category = (object)[
                'name' => 'Budaya & Sejarah',
                'slug' => 'budaya-sejarah',
                'icon' => '🏛️',
                'description' => 'Jelajahi warisan budaya dan situs bersejarah Delta Brantas.',
                'image' => $budayaCat ? $budayaCat->image : '',
            ];

            $featured = Destination::whereIn('category_id', $categoryIds)->where('status', 'Aktif')->where('is_featured', 1)->first();
            $regularItemsQuery = Destination::whereIn('category_id', $categoryIds)->where('status', 'Aktif');
            if ($featured) {
                $regularItemsQuery->where('id', '!=', $featured->id);
            }
            $regularItems = $regularItemsQuery->get();
        } else {
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $featured = Destination::where('category_id', $category->id)->where('status', 'Aktif')->where('is_featured', 1)->first();
            $regularItemsQuery = Destination::where('category_id', $category->id)->where('status', 'Aktif');
            if ($featured) {
                 $regularItemsQuery->where('id', '!=', $featured->id);
            }
            $regularItems = $regularItemsQuery->get();
        }

        return view('pages.explore.category', [
            'category' => $category,
            'categories' => $categories,
            'featured' => $featured,
            'regularItems' => $regularItems,
            'filterTabs' => $filterTabs,
            'currentSlug' => $category_slug,
        ]);
    }

    public function exploreDetail($category_slug, $item_slug)
    {
        if ($category_slug === 'kuliner') {
            $category = Category::where('slug', 'kuliner')->first();
            if (!$category) {
                $category = (object)[
                    'name' => 'Wisata Kuliner',
                    'slug' => 'kuliner',
                    'icon' => '🍲',
                    'description' => 'Eksplorasi kuliner khas Delta Brantas.',
                    'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070'
                ];
            }
            $item = Culinary::where('slug', $item_slug)->where('status', 'Aktif')->firstOrFail();
            $related = Culinary::where('slug', '!=', $item_slug)->where('status', 'Aktif')->take(3)->get()->map(function($c) {
                $c->category = (object)['slug' => 'kuliner'];
                return $c;
            });
            $item->category = (object)['slug' => 'kuliner'];
        } elseif ($category_slug === 'budaya-sejarah') {
            $budayaCat = Category::where('slug', 'budaya')->first();
            $sejarahCat = Category::where('slug', 'sejarah')->first();
            $categoryIds = collect([$budayaCat, $sejarahCat])->filter()->pluck('id');

            $category = (object)[
                'name' => 'Budaya & Sejarah',
                'slug' => 'budaya-sejarah',
                'icon' => '🏛️',
                'description' => 'Jelajahi warisan budaya dan situs bersejarah Delta Brantas.',
                'image' => $budayaCat ? $budayaCat->image : '',
            ];

            $item = Destination::whereIn('category_id', $categoryIds)->where('slug', $item_slug)->where('status', 'Aktif')->firstOrFail();
            $related = Destination::whereIn('category_id', $categoryIds)->where('slug', '!=', $item_slug)->where('status', 'Aktif')->take(3)->get();
        } else {
            $category = Category::where('slug', $category_slug)->firstOrFail();
            $item = Destination::where('category_id', $category->id)->where('slug', $item_slug)->where('status', 'Aktif')->firstOrFail();
            $related = Destination::where('category_id', $category->id)->where('slug', '!=', $item_slug)->where('status', 'Aktif')->take(3)->get();
        }

        return view('pages.explore.detail', [
            'category' => $category,
            'item' => $item,
            'related' => $related,
        ]);
    }

    public function tentang()
    {
        return view('pages.tentang.index');
    }

    public function peta()
    {
        $locations = collect();

        // ── Ambil dari DB: Destinasi Wisata Alam ──
        $wisataAlam = Destination::with('category')
            ->whereHas('category', fn($q) => $q->where('slug', 'wisata-alam'))
            ->where('status', 'Aktif')
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get()
            ->map(fn($d) => [
                'title'    => $d->name,
                'category' => 'alam',
                'icon'     => '🌿',
                'lat'      => (float)$d->latitude,
                'lng'      => (float)$d->longitude,
                'desc'     => $d->description ?? '-',
                'alamat'   => $d->location ?? '-',
            ]);

        // ── Ambil dari DB: Budaya & Sejarah ──
        $bsCategoryIds = \App\Models\Category::whereIn('slug', ['budaya', 'sejarah'])->pluck('id');
        $budaya = Destination::whereIn('category_id', $bsCategoryIds)
            ->where('status', 'Aktif')
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get()
            ->map(fn($d) => [
                'title'    => $d->name,
                'category' => 'budaya',
                'icon'     => '🏛️',
                'lat'      => (float)$d->latitude,
                'lng'      => (float)$d->longitude,
                'desc'     => $d->description ?? '-',
                'alamat'   => $d->location ?? '-',
            ]);

        // ── Ambil dari DB: Kuliner ──
        $kuliner = Culinary::where('status', 'Aktif')
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get()
            ->map(fn($c) => [
                'title'    => $c->name,
                'category' => 'kuliner',
                'icon'     => '🍜',
                'lat'      => (float)$c->latitude,
                'lng'      => (float)$c->longitude,
                'desc'     => $c->description ?? '-',
                'alamat'   => $c->location ?? '-',
            ]);

        $locations = $wisataAlam->concat($budaya)->concat($kuliner);

        // ── Fallback: jika DB masih kosong, tampilkan data contoh ──
        if ($locations->isEmpty()) {
            $locations = collect([
                ['title' => 'Wisata Bahari Tlocor (Pulau Lusi)', 'category' => 'alam', 'icon' => '🌿', 'lat' => -7.5527, 'lng' => 112.8452, 'desc' => 'Ekowisata mangrove dan pulau lumpur di muara Sungai Porong.', 'alamat' => 'Jl. Dermaga Tlocor, Desa Kedung Pandan, Jabon, Sidoarjo'],
                ['title' => 'Pantai Kepetingan',                 'category' => 'alam', 'icon' => '🌿', 'lat' => -7.5610, 'lng' => 112.8180, 'desc' => 'Pantai dengan hutan mangrove lebat dan ekosistem burung bangau.', 'alamat' => 'Desa Sawohan, Kec. Buduran, Sidoarjo'],
                ['title' => 'Alun-Alun Sidoarjo',                'category' => 'budaya', 'icon' => '🏛️', 'lat' => -7.4458, 'lng' => 112.7178, 'desc' => 'Pusat kota dan ruang publik ikonik Sidoarjo.', 'alamat' => 'Jl. Sultan Agung, Sidokumpul, Sidoarjo'],
                ['title' => 'Monumen Jayandaru',                 'category' => 'budaya', 'icon' => '🏛️', 'lat' => -7.4502, 'lng' => 112.7165, 'desc' => 'Monumen kebanggaan Sidoarjo, indah di malam hari.', 'alamat' => 'Jl. Jenggolo No. 21, Sidokumpul, Sidoarjo'],
                ['title' => 'Museum Mpu Tantular',               'category' => 'budaya', 'icon' => '🏛️', 'lat' => -7.4278, 'lng' => 112.7235, 'desc' => 'Museum sejarah Jawa Timur dengan koleksi arkeologi dan budaya.', 'alamat' => 'Jl. Raya Buduran, Sidoarjo'],
                ['title' => 'Kampung Batik Jetis',               'category' => 'budaya', 'icon' => '🏛️', 'lat' => -7.4525, 'lng' => 112.7212, 'desc' => 'Sentra batik tulis khas Sidoarjo dengan motif unik.', 'alamat' => 'Jl. P. Diponegoro, Lemahputro, Sidoarjo'],
                ['title' => 'Candi Pari',                        'category' => 'budaya', 'icon' => '🏛️', 'lat' => -7.5505, 'lng' => 112.7230, 'desc' => 'Situs candi Hindu peninggalan Majapahit abad ke-14.', 'alamat' => 'Desa Candi Pari, Kec. Porong, Sidoarjo'],
                ['title' => 'Sentra Kupang Lontong',             'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4620, 'lng' => 112.7090, 'desc' => 'Pusat kuliner lontong kupang otentik khas Sidoarjo.', 'alamat' => 'Pasar Larangan, Kec. Candi, Sidoarjo'],
                ['title' => 'Rawon Gajah Mada',                  'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4480, 'lng' => 112.7150, 'desc' => 'Rawon legendaris cita rasa khas Sidoarjo.', 'alamat' => 'Jl. Gajah Mada, Pekauman, Sidoarjo'],
                ['title' => 'Pazkul (Pusat Kuliner Sidoarjo)',   'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4385, 'lng' => 112.7460, 'desc' => 'Food court modern dengan ratusan pilihan kuliner lokal.', 'alamat' => 'Jl. Jati, Kahuripan Nirwana, Sidoarjo'],
                ['title' => 'Sentra Bandeng Asap',               'category' => 'kuliner', 'icon' => '🍜', 'lat' => -7.4466, 'lng' => 112.7310, 'desc' => 'Pusat oleh-oleh bandeng asap dan presto khas Sidoarjo.', 'alamat' => 'Jl. Raya Sidoarjo – Surabaya, Sidoarjo'],
            ]);
        }

        $popularLocations = $locations->take(8)->map(fn($l) => [
            'title'    => $l['title'],
            'category' => $l['category'] === 'alam' ? 'Wisata Alam' : ($l['category'] === 'budaya' ? 'Budaya & Sejarah' : 'Kuliner'),
            'icon'     => $l['icon'],
            'url'      => $l['category'] === 'kuliner' ? '/explore/kuliner' : ($l['category'] === 'budaya' ? '/explore/budaya-sejarah' : '/explore/wisata-alam'),
        ])->values()->toArray();

        return view('pages.peta.index', [
            'locations'        => $locations->values()->toArray(),
            'popularLocations' => $popularLocations,
        ]);
    }


    public function kontak()
    {
        return view('pages.kontak.index');
    }

    public function beritaIndex()
    {
        $featured = Article::where('status', 'Publikasi')->orderBy('published_at', 'desc')->first();
        $articles = Article::where('status', 'Publikasi')->orderBy('published_at', 'desc')->skip(1)->take(10)->get();

        return view('pages.berita.index', [
            'featured' => $featured,
            'articles' => $articles,
        ]);
    }

    public function beritaDetail($slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'Publikasi')->firstOrFail();
        $related = Article::where('slug', '!=', $slug)->where('status', 'Publikasi')->orderBy('published_at', 'desc')->take(2)->get();

        return view('pages.berita.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function adminDashboard()
    {
        $destinations = Destination::with('category')
            ->whereHas('category', fn($q) => $q->where('slug', 'wisata-alam'))
            ->orderBy('id', 'desc')->get();

        $budayaCategory = Category::where('slug', 'budaya')->first();
        $sejarahCategory = Category::where('slug', 'sejarah')->first();

        $budayaItems = Destination::with('category')
            ->where('category_id', $budayaCategory?->id)
            ->orderBy('id', 'desc')->get();

        $sejarahItems = Destination::with('category')
            ->where('category_id', $sejarahCategory?->id)
            ->orderBy('id', 'desc')->get();

        $culinaries = Culinary::orderBy('id', 'desc')->get();
        $articles = Article::orderBy('id', 'desc')->get();
        $mapLocations = MapLocation::orderBy('id', 'desc')->get();

        return view('pages.admin.dashboard', [
            'destinations' => $destinations,
            'budayaItems' => $budayaItems,
            'sejarahItems' => $sejarahItems,
            'culinaries' => $culinaries,
            'articles' => $articles,
            'mapLocations' => $mapLocations,
            'budayaCategoryId' => $budayaCategory?->id,
            'sejarahCategoryId' => $sejarahCategory?->id,
        ]);
    }
}
