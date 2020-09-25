<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('League\Glide\Server', function ($app) {
            return \League\Glide\ServerFactory::create([
                'source'                => \Illuminate\Support\Facades\Storage::disk('minio')->getDriver(),
                'cache'                 => \Illuminate\Support\Facades\Storage::disk('local')->getDriver(),
                'cache_path_prefix'     => '.cache/images',
                'useSecureURLs'         => false,
                'response' => new \League\Glide\Responses\LaravelResponseFactory(app('request'))
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
