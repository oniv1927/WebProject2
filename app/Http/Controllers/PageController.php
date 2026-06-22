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

        return view('pages.explore.index', [
            'categories' => $categories,
            'allItems' => $allItems,
        ]);
    }

    public function exploreCategory($category_slug)
    {
        $categories = Category::all();

        if ($category_slug === 'kuliner') {
            $category = Category::where('slug', 'kuliner')->first();
            if (!$category) {
                // If culinary is not a category in db, create a fake one
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
                $c->category = (object)['slug' => 'kuliner']; // Fake relationship
                return $c;
            });
            if ($featured) {
                 $featured->category = (object)['slug' => 'kuliner'];
            }
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
        // For admin dashboard, we load data from DB and pass to view as JSON
        // so the JS can render it initially. We don't need localStorage anymore.
        $destinations = Destination::orderBy('id', 'desc')->get();
        $culinaries = Culinary::orderBy('id', 'desc')->get();
        $articles = Article::orderBy('id', 'desc')->get();

        return view('pages.admin.dashboard', [
            'destinations' => $destinations,
            'culinaries' => $culinaries,
            'articles' => $articles,
        ]);
    }
}
