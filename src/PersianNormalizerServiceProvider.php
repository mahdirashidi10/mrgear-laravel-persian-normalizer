<?php

namespace MRGear\PersianNormalizer;


use Illuminate\Support\ServiceProvider;
use MRGear\PersianNormalizer\Middleware\PersianNormalizerMiddleware;
class PersianNormalizerServiceProvider extends ServiceProvider
{
    /**
     * Register the application's services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the Normalizer class to the container with the name 'persian-normalizer'
        $this->app->singleton('mrgear-persian-normalizer', function ($app) {
            return new NormalizerManager();
        });
    }

    /**
     * Bootstrap the application's services.
     *
     * @return void
     */
    public function boot()
    {
        // You can publish the config file if necessary
        $this->publishes([
            __DIR__.'/../config/mrgear-persian-normalizer.php' => config_path('mrgear-persian-normalizer.php'),
        ], 'config');

        // Register the Middleware with a custom alias name
        $this->app['router']->aliasMiddleware('mrgear-persian-normalizer', PersianNormalizerMiddleware::class);
    }
}
