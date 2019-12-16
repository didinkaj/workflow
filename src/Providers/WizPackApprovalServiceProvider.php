<?php


namespace WizPack\Workflow\Providers;

use Illuminate\Support\ServiceProvider;
use WizPack\Workflow\Http\Controllers\AppBaseController;

class WizPackApprovalServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('wiz-pack-approval', function () {
            return new AppBaseController();
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(dirname(__DIR__) . '/Views', 'wizpack');
    }

}