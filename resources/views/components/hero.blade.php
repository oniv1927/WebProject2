{{-- Reusable Hero Component
     Props: $badge, $title, $description, $image, $compact, $buttons
     Slots: buttons (for CTA buttons) --}}
@props([
    'badge' => '',
    'title' => 'Portal Wisata & Budaya',
    'description' => '',
    'image' => 'https://images.unsplash.com/photo-1596402184320-4174ca1817e0?q=80&w=2070&auto=format&fit=crop',
    'compact' => false,
    'buttons' => [],
])

@php
    $heroClass = 'hero' . ($compact ? ' hero-compact' : '');
@endphp

<section class="{{ $heroClass }}" style="background: var(--bg-primary);">
    <div class="hero-overlay" style="background: radial-gradient(circle at 50% 50%, rgba(34, 197, 94, 0.05), transparent 70%);"></div>

    <div class="container">
        <div class="hero-content">
            @if($badge)
                <div class="hero-badge reveal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $badge }}
                </div>
            @endif

            <h1 class="hero-title reveal reveal-delay-1">{!! $title !!}</h1>

            @if($description)
                <p class="hero-description reveal reveal-delay-2">{{ $description }}</p>
            @endif

            @if(!empty($buttons) || isset($buttonsSlot))
                <div class="hero-buttons reveal reveal-delay-3">
                    @if(!empty($buttons))
                        @foreach($buttons as $btn)
                            <a href="{{ $btn['url'] }}" class="btn {{ $btn['style'] ?? 'btn-primary' }}">
                                {!! $btn['icon'] ?? '' !!}
                                {{ $btn['label'] }}
                            </a>
                        @endforeach
                    @endif
                    {{ $buttonsSlot ?? '' }}
                </div>
            @endif
        </div>
    </div>

    @unless($compact)
        <div class="hero-scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    @endunless
</section>
