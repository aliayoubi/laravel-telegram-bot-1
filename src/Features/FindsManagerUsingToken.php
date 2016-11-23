<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\Manager;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;

trait FindsManagerUsingToken
{
    /**
     * Tries to find a bot manager using given token.
     *
     * @param  string $token
     *
     * @return null|\SumanIon\TelegramBot\Manager
     */
    public static function findManagerWithToken(string $token)
    {
        $token = substr($token, 0, 100);
        $files = glob(Container::getInstance()->basePath('app/Bots/*.php'));
        $bots  = (new Collection($files))->map(function ($file) {

            $fqcn = 'App\\Bots\\' . pathinfo($file, PATHINFO_FILENAME);

            if (class_exists($fqcn)) {

                $bot = new $fqcn;

                if ($bot instanceof Manager) {

                    return $bot;
                }
            }
        });

        return $bots->first(function ($bot) use ($token) {

            return is_object($bot) and $bot->token() === $token;
        });
    }
}