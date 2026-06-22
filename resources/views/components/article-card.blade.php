{{-- Article Card Component
     Props: $image, $date, $title, $excerpt, $url --}}
@props([
    'image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=800&auto=format&fit=crop',
    'date' => '12 Juni 2026',
    'title' => 'Judul Artikel',
    'excerpt' => 'Ringkasan artikel akan muncul di sini.',
    'url' => '#',
])

<div class="article-card reveal">
    <div class="article-card-image">
        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
    </div>
    <div class="article-card-body">
        <span class="article-date">{{ $date }}</span>
        <h3>{{ $title }}</h3>
        <p>{{ $excerpt }}</p>
        <a href="{{ $url }}" class="read-more">
            Baca Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
