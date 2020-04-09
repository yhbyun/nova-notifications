<?php

namespace Mirovit\NovaNotifications;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Mirovit\NovaNotifications\Http\Middleware\Authorize;

class NovaNotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-notifications');
        $this->publishes([
            __DIR__ . '/../config/notifications.php' => config_path('nova-notifications.php'),
        ]);

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'userModel' => config('nova-notifications.userModel'),
                'wsHost' => config('nova-notifications.wsHost'),
                'wsPort' => config('nova-notifications.wsPort'),
                'wsPath' => config('nova-notifications.wsPath'),
            ]);
            Nova::translations(__DIR__ . '/../resources/lang/' . app()->getLocale() . '/lang.json');
        });
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
                ->prefix('nova-vendor/nova-notifications')
                ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/notifications.php',
            'nova-notifications'
        );
    }
}
