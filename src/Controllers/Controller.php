<?php

namespace SumanIon\TelegramBot\Controllers;

use SumanIon\TelegramBot\Manager;
use Illuminate\Container\Container;
use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    /** @var \SumanIon\TelegramBot\Manager */
    protected $manager;

    /** @var \Illuminate\Container\Container */
    protected $app;

    /**
     * Tries to find a manager with the given token.
     *
     * @param  string $token
     *
     * @return void
     */
    protected function findManager(string $token)
    {
        $this->app     = Container::getInstance();
        $this->manager = Manager::findManagerWithToken($token);

        if (!$this->manager) {

            $this->app->abort(404);
        }
    }
}