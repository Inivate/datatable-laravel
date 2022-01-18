<?php

namespace Inivate\DatatableLaravel;

use Illuminate\Support\ServiceProvider;

class DatatableServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'datatable');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/datatable'),
            __DIR__.'/resources/assets' => public_path('assets/datatable'),
        ]);
        
    }

    public function register()
    {
        
    }
}