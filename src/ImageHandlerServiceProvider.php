<?php

namespace Codepane\LaravelImageHandler;

use Illuminate\Support\ServiceProvider;

class ImageHandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/imagehandler.php',
            'imagehandler');

        $this->app->bind('imagehandler', function($app) {
            return new ImageHandler();
        });

    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/imagehandler.php' => config_path('imagehandler.php'),
          ], 'imagehandler');

    }
}
