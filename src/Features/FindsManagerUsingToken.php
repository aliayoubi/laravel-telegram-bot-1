<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\Manager;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;

trait FindsManagerUsingToken
{
    /**
     * Returns a collection with all available Bot managers.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function findAllManagers()
    {
        $files = glob(Container::getInstance()->basePath('app/Bots/*TelegramBot.php'));

        return (new Collection($files))->map(function ($file) {

            $fqcn = 'App\\Bots\\' . pathinfo($file, PATHINFO_FILENAME);

            if (class_exists($fqcn)) {

                return new $fqcn;
            }
        })->filter(function ($manager) {

            return is_object($manager) and $manager instanceof Manager;
        });
    }

    /**
     * Tries to find a Bot manager using given token.
     *
     * @param  string $token
     *
     * @return null|\SumanIon\TelegramBot\Manager
     */
    public static function findManagerWithToken(string $token)
    {
        $token = substr($token, 0, 100);

        return static::findAllManagers()->first(function ($bot) use ($token) {

            return is_object($bot) and $bot->token() === $token;
        });
    }
}