<?php

namespace Taskforcedev\CrudAPI\Providers;

use Illuminate\Support\ServiceProvider;

class CrudApi extends ServiceProvider
{
    public function boot()
    {
        /* Load our routes */
        $this->loadRoutes();

        /* Register config file */
        $this->config();
    }
    
    public function register()
    {
		$this->mergeConfigFrom(
    		__DIR__.'/../config/crudapi.php', 'crudapi'
		);
    }

    protected function config()
    {
        $this->publishes([
            __DIR__.'/../config/crudapi.php' => config_path('crudapi.php'),
        ]);
    }

    protected function loadRoutes()
    {
        $routes_path = __DIR__.'/../Http/routes.php';
        if (file_exists($routes_path)) {
            include __DIR__.'/../Http/routes.php';
        }
    }
}
