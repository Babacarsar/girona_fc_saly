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
        $this->app->booting(function () {
            if (getenv('DB_CONNECTION') === 'pgsql') {
                config([
                    'database.default' => 'pgsql',
                    'database.connections.pgsql.charset' => 'utf8',
                ]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
  

public function boot()
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
   ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
}
}
