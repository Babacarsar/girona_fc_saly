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
                if (getenv('DB_CHARSET') === 'utf8mb4') {
                    putenv('DB_CHARSET=UTF8');
                }
                $pgsql = config('database.connections.pgsql', []);
                unset($pgsql['charset'], $pgsql['url']);
                config([
                    'database.default' => 'pgsql',
                    'database.connections.pgsql' => $pgsql,
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
