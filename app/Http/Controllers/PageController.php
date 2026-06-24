<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Article;
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

        return view('pages.home', [
            'categories' => $categories,
            'destinations' => $destinations,
            'articles' => $articles,
            'culinaries' => $culinaries,
        ]);
    }

    public function exploreIndex()
    {
        $categories = Category::withCount('destinations')->get();
        $allDestinations = Destination::with('category')->where('status', 'Aktif')->get();
        
        // Gabungkan Destinasi dan Kuliner (karena sebelumnya digabung)
        $allCulinary = Culinary::where('status', 'Aktif')->get()->map(function($c) {
            $c->category = (object)['slug' => 'kuliner']; // Fake relationship for view
            return $c;
        });

        $allItems = $allDestinations->concat($allCulinary);

        // Count for combined Budaya & Sejarah
        $bsCategoryIds = Category::whereIn('slug', ['budaya', 'sejarah'])->pluck('id');
        $budayaSejarahCount = Destination::whereIn('category_id', $bsCategoryIds)->where('status', 'Aktif')->count();

        // Filter tabs for explore pages
        $filterTabs = [
            ['slug' => '', 'name' => 'Semua'],
            ['slug' => 'wisata-alam', 'name' => 'Wisata Alam'],
            ['slug' => 'kuliner', 'name' => 'Kuliner'],
            ['slug' => 'budaya-sejarah', 'name' => 'Budaya & Sejarah'],
        ];

        return view('pages.explore.index', [
            'categories' => $categories,
            'allItems' => $allItems,
            'budayaSejarahCount' => $budayaSejarahCount,
            'filterTabs' => $filterTabs,
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

        return view('pages.admin.dashboard', [
            'destinations' => $destinations,
            'budayaItems' => $budayaItems,
            'sejarahItems' => $sejarahItems,
            'culinaries' => $culinaries,
            'articles' => $articles,
            'budayaCategoryId' => $budayaCategory?->id,
            'sejarahCategoryId' => $sejarahCategory?->id,
        ]);
    }
}
