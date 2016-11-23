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

                $this->app->get('/telegram-bot/webhook/{token}/enable', 'WebhookController@enable');
                $this->app->get('/telegram-bot/webhook/{token}/disable', 'WebhookController@disable');
                $this->app->post('/telegram-bot/webhook/{token}', 'WebhookController@handle');
            });

        } else {

            $this->app['router']->group([
                'middleware' => 'api',
                'namespace' => 'SumanIon\TelegramBot\Controllers',
                'prefix' => 'api',
            ], function () {

                $this->app['router']->get('/telegram-bot/webhook/{token}/enable', 'WebhookController@enable');
                $this->app['router']->get('/telegram-bot/webhook/{token}/disable', 'WebhookController@disable');
                $this->app['router']->post('/telegram-bot/webhook/{token}', 'WebhookController@handle');
            });
        }
    }
}