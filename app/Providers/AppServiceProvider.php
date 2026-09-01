<?php

namespace App\Providers;

use App\Auth\GuruUserProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\IzinService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          Auth::provider('guru', function ($app, array $config) {
            return new GuruUserProvider();
        });
          // Morph map: alias lama → class yang sekarang dipakai
    Relation::morphMap([
        'App\Models\Admin\Tizin' => \App\Models\Tizin::class,
    ]);
    }
}
