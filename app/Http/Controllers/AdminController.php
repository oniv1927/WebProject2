<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Culinary;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Handle image upload to storage/app/public
     */
    private function uploadImage(Request $request, $fieldName = 'image', $directory = 'images')
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $file->validate([
                $fieldName => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
            ]);
            return $file->store($directory, 'public');
        }
        return null;
    }

    /**
     * Delete old image from storage
     */
    private function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    // ══════════════════════════════════════════════
    //  DESTINATION CRUD (Wisata Alam)
    // ══════════════════════════════════════════════
    public function storeDestination(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/destinations', 'public');
        }
        
        // Random assign to Wisata Alam / Budaya / Sejarah
        $cats = Category::whereIn('slug', ['wisata-alam', 'budaya', 'sejarah'])->pluck('id')->toArray();
        if(count($cats) > 0) {
            $data['category_id'] = $cats[array_rand($cats)];
        }

        $dest = Destination::create($data);
        $dest->load('category');
        return response()->json($dest);
    }

    public function updateDestination(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $this->deleteImage($dest->image);
            $data['image'] = $request->file('image')->store('images/destinations', 'public');
        }

        $dest->update($data);
        $dest->load('category');
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
        $dest = Destination::findOrFail($id);
        $this->deleteImage($dest->image);
        $dest->delete();
        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════
    //  ARTICLE CRUD
    // ══════════════════════════════════════════════
    public function storeArticle(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['published_at'] = now();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/articles', 'public');
        }
        
        $art = Article::create($data);
        return response()->json($art);
    }

    public function updateArticle(Request $request, $id)
    {
        $art = Article::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($art->image);
            $data['image'] = $request->file('image')->store('images/articles', 'public');
        }

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
        $art = Article::findOrFail($id);
        $this->deleteImage($art->image);
        $art->delete();
        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════
    //  CULINARY CRUD
    // ══════════════════════════════════════════════
    public function storeCulinary(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category_type' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/culinaries', 'public');
        }
        
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($cul->image);
            $data['image'] = $request->file('image')->store('images/culinaries', 'public');
        }

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
        $cul = Culinary::findOrFail($id);
        $this->deleteImage($cul->image);
        $cul->delete();
        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════
    //  BUDAYA CRUD (Destination with category=budaya)
    // ══════════════════════════════════════════════
    public function storeBudaya(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;
        $data['is_featured'] = $request->boolean('is_featured');

        $budayaCategory = Category::where('slug', 'budaya')->first();
        $data['category_id'] = $budayaCategory?->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/budaya', 'public');
        }

        $dest = Destination::create($data);
        $dest->load('category');
        return response()->json($dest);
    }

    public function updateBudaya(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $this->deleteImage($dest->image);
            $data['image'] = $request->file('image')->store('images/budaya', 'public');
        }

        $dest->update($data);
        $dest->load('category');
        return response()->json($dest);
    }

    public function toggleBudayaStatus(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $dest->status = $dest->status === 'Aktif' ? 'Draft' : 'Aktif';
        $dest->save();
        return response()->json($dest);
    }

    public function toggleBudayaFeatured(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $dest->is_featured = !$dest->is_featured;
        $dest->save();
        return response()->json($dest);
    }

    public function destroyBudaya($id)
    {
        $dest = Destination::findOrFail($id);
        $this->deleteImage($dest->image);
        $dest->delete();
        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════
    //  SEJARAH CRUD (Destination with category=sejarah)
    // ══════════════════════════════════════════════
    public function storeSejarah(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $data['rating'] = rand(40, 50) / 10;
        $data['is_featured'] = $request->boolean('is_featured');

        $sejarahCategory = Category::where('slug', 'sejarah')->first();
        $data['category_id'] = $sejarahCategory?->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/sejarah', 'public');
        }

        $dest = Destination::create($data);
        $dest->load('category');
        return response()->json($dest);
    }

    public function updateSejarah(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $this->deleteImage($dest->image);
            $data['image'] = $request->file('image')->store('images/sejarah', 'public');
        }

        $dest->update($data);
        $dest->load('category');
        return response()->json($dest);
    }

    public function toggleSejarahStatus(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $dest->status = $dest->status === 'Aktif' ? 'Draft' : 'Aktif';
        $dest->save();
        return response()->json($dest);
    }

    public function toggleSejarahFeatured(Request $request, $id)
    {
        $dest = Destination::findOrFail($id);
        $dest->is_featured = !$dest->is_featured;
        $dest->save();
        return response()->json($dest);
    }

    public function destroySejarah($id)
    {
        $dest = Destination::findOrFail($id);
        $this->deleteImage($dest->image);
        $dest->delete();
        return response()->json(['success' => true]);
    }
}

