<?php
namespace Shibaji\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Shibaji\Admin\Components\Alert;
use Shibaji\Admin\Console\Commands\Admin;
use Shibaji\Admin\Menus\LeftMenu;

class AdminServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/admin.php', 'admin'
        );
    }

    public function boot(){
        Schema::defaultStringLength(191);

        $lf = new LeftMenu();

        $lf->append('app', [
            'link' => '',
            'label' => 'Test Menu',
            'child' => [
                [
                    'link' => '#',
                    'label' => 'Test Submenu'
                ]
            ]
        ]);

        $this->loadFactoriesFrom(__DIR__.'/database/factories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'admin');
        $this->loadTranslationsFrom(__DIR__.'/translations', 'admin');
        $this->loadViewComponentsAs('admin', [
            Alert::class,
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                Admin::class,
            ]);
        }
        view()->share('assetLink', config('admin.assets', 'assets'));
        view()->share('user', Auth::user());

        $this->publishes([
            __DIR__.'/assets' => public_path(config('admin.assets', 'assets')),
        ], 'admin-assets');

        $this->publishes([
            __DIR__.'/config/admin.php' => config_path('admin.php'),
        ], 'admin-config');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/admin'),
            __DIR__.'/translations' => resource_path('lang/vendor/courier'),
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ]);
    }
}
