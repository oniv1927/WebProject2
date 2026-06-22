{{-- Cultural Card Component
     Props: $icon, $title, $description --}}
@props([
    'icon' => '🏛️',
    'title' => 'Budaya & Tradisi',
    'description' => 'Deskripsi singkat tentang budaya.',
])

<div class="cultural-card reveal">
    <div class="cultural-card-icon">
        {{ $icon }}
    </div>
    <h3>{{ $title }}</h3>
    <p>{{ $description }}</p>
</div>
