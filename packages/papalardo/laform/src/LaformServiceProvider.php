<?php

namespace Papalardo\Laform;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaformServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'laform');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if (TRUE || env('APP_ENV') == 'testing') {
            $this->loadMigrationsFrom(__DIR__.'/Tests/database/migrations');
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Papalardo\Laform\Config\Upload\ImageUploadConfig::class, function($app) {
            $config = new \Papalardo\Laform\Config\Upload\ImageUploadConfig;
            
            $config->setCsrfToken(csrf_token());

            if(Route::has('laform::images.store')) {
                $config->setEndpoint(route('laform::images.store'));
            }
            
            return $config;
        });

        $this->app->bind(\Papalardo\Laform\Config\Upload\FileUploadConfig::class, function($app) {
            $config = new \Papalardo\Laform\Config\Upload\FileUploadConfig;
            
            $config->setCsrfToken(csrf_token());

            if(Route::has('laform::files.store')) {
                $config->setEndpoint(route('laform::files.store'));
            }
            
            return $config;
        });
    }
}
