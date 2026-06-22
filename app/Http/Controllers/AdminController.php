<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // DESTINATION CRUD
    public function storeDestination(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|string'
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;
        
        // Random assign to Wisata Alam / Budaya / Sejarah
        $cats = Category::whereIn('slug', ['wisata-alam', 'budaya', 'sejarah'])->pluck('id')->toArray();
        if(count($cats) > 0) {
            $data['category_id'] = $cats[array_rand($cats)];
        }

        $dest = Destination::create($data);
        return response()->json($dest);
    }

    public function updateDestination(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|string'
        ]);

        $dest->update($data);
        return response()->json($dest);
    }

    public function toggleDestinationStatus(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $dest->status = $dest->status === 'Aktif' ? 'Draft' : 'Aktif';
        $dest->save();
        return response()->json($dest);
    }

    public function destroyDestination($id)
    {
        Destination::destroy($id);
        return response()->json(['success' => true]);
    }

    // ARTICLE CRUD
    public function storeArticle(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['published_at'] = now();
        
        $art = Article::create($data);
        return response()->json($art);
    }

    public function updateArticle(Request $request, $id)
    {
        $art = Article::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|string'
        ]);

        $art->update($data);
        return response()->json($art);
    }

    public function toggleArticleStatus(Request $request, $id)
    {
        $art = Article::findOrFail($id);
        $art->status = $art->status === 'Publikasi' ? 'Draft' : 'Publikasi';
        $art->save();
        return response()->json($art);
    }

    public function destroyArticle($id)
    {
        Article::destroy($id);
        return response()->json(['success' => true]);
    }

    // CULINARY CRUD
    public function storeCulinary(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category_type' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;
        
        $cul = Culinary::create($data);
        return response()->json($cul);
    }

    public function updateCulinary(Request $request, $id)
    {
        $cul = Culinary::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'category_type' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $cul->update($data);
        return response()->json($cul);
    }

    public function toggleCulinaryStatus(Request $request, $id)
    {
        $cul = Culinary::findOrFail($id);
        $cul->status = $cul->status === 'Aktif' ? 'Draft' : 'Aktif';
        $cul->save();
        return response()->json($cul);
    }

    public function destroyCulinary($id)
    {
        Culinary::destroy($id);
        return response()->json(['success' => true]);
    }
}
