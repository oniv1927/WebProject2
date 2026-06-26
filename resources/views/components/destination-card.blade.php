{{-- Destination Card Component --}}
@props([
    'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=800&auto=format&fit=crop',
    'badge' => 'Unggulan',
    'title' => 'Nama Destinasi',
    'location' => 'Sidoarjo, Jawa Timur',
    'rating' => '4.8',
    'description' => '',
    'url' => '',
])

<div class="destination-card reveal">
    <div class="destination-card-image">
        <img src="@imgurl($image)" alt="{{ $title }}" loading="lazy">
        <div class="card-overlay"></div>
        @if($badge)
            <span class="card-badge">{{ $badge }}</span>
        @endif
    </div>
    <div class="destination-card-body">
        <h3>
            @if($url)
                <a href="{{ $url }}">{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        </h3>
        <div class="card-location">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $location }}
        </div>
        <div class="card-rating">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span>{{ $rating }}</span>
        </div>
        @if($description)
            <p class="card-desc">{{ $description }}</p>
        @endif
    </div>
</div>
