<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
 use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
  

public function boot()
{
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
   }
   ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
}
}
