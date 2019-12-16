<?php


namespace WizPack\Workflow\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


class WizPackRouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'WizPack\Workflow\Http\Controllers';

    public function map()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

}