<?php

namespace SumanIon\TelegramBot\Providers;

use Illuminate\Support\ServiceProvider;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['view']->addNamespace('telegram', __DIR__ . '/../../assets/views');
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
        $this->loadCustomRoutes();
    }

    /**
     * Loads custom Api routes.
     *
     * @return void
     */
    public function loadCustomRoutes()
    {
        if (strpos($this->app->version(), 'Lumen') !== false) {

            $this->app->group([
                'namespace' => 'SumanIon\TelegramBot\Controllers',
                'prefix'    => 'api'
            ], function () {

                $router = $this->app;

                require __DIR__ . '/../../routes/api.php';
            });

        } else {

            $this->app['router']->group([
                'middleware' => 'api',
                'namespace' => 'SumanIon\TelegramBot\Controllers',
                'prefix' => 'api',
            ], function () {

                $router = $this->app['router'];

                require __DIR__ . '/../../routes/api.php';
            });
        }
    }
}