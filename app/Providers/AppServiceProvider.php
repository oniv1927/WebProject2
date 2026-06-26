<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * @imgurl Blade directive
         * Resolves image paths for both external URLs and local storage paths.
         * - http/https URLs -> displayed as-is
         * - Local paths (e.g. images/destinations/xxx.png) -> asset('storage/...')
         * - Empty/null -> empty string
         */
        Blade::directive('imgurl', function ($expression) {
            return "<?php echo e(\App\Helpers\ImageHelper::url({$expression})); ?>";
        });
    }
}
