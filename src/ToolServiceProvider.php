<?php

namespace Milkhan\NovaHelp;

use Milkhan\NovaHelp\Library\MarkdownUtility;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Milkhan\NovaHelp\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    private $config = 'novahelp';

    /**
     * @var MarkdownUtility $utility
     */
    protected $utility;

    /**
     * Bootstrap any application services.
     *
     * @throws \Exception
     * @return void
     */
    public function boot()
    {
        $this->utility = new MarkdownUtility();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-help');

        $this->app->booted(function () {
            $this->routes();
        });

        $options = $this->utility->buildPageRoutes();

        Nova::serving(function (ServingNova $event) use ($options) {
            Nova::provideToScript([
                'pages' => $options,
            ]);
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/'.$this->config.'.php' => base_path('config/'.$this->config.'.php'),
            ], 'config');
        }

        $this->publishes([
            __DIR__.'/../resources/help/home.md' => resource_path('help/home.md'),
            __DIR__.'/../resources/help/sample.md' => resource_path('help/sample.md'),
        ]);
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-help')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/'.$this->config.'.php', $this->config);
    }
}
