{{-- Food Card Component
     Props: $image, $title, $description --}}
@props([
    'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=800&auto=format&fit=crop',
    'title' => 'Nama Makanan',
    'description' => 'Deskripsi singkat kuliner khas.',
])

<div class="food-card reveal">
    <div class="food-card-image">
        <img src="@imgurl($image)" alt="{{ $title }}" loading="lazy">
    </div>
    <div class="food-card-body">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
    </div>
</div>
