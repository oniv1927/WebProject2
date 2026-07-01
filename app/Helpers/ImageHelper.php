<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Resolve image URL for both external URLs and local storage paths.
     *
     * - http/https URLs → returned as-is
     * - Local paths (e.g. images/destinations/xxx.png) → asset('storage/...')
     * - Empty/null → returns empty string
     *
     * @param string|null $path
     * @return string
     */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // External URL (Unsplash, CDN, etc.) → use directly
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // If the file exists in public/ directly (e.g. public/images/xxx)
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Local storage path → resolve via asset('storage/...')
        return asset('storage/' . $path);
    }
}
