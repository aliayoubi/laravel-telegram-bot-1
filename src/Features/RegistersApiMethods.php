<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\ParsedUpdate;

trait RegistersApiMethods
{
    /**
     * Returns basic information about current bot.
     *
     * @return array
     */
    public function getMe():ParsedUpdate
    {
        return current($this->sendRequest('GET', 'getMe'));
    }

    /**
     * Returns latest updates of the Bot.
     *
     * @param  int    $offset
     * @param  int    $limit
     * @param  int    $timeout
     *
     * @return array
     */
    public function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 0):array
    {
        return $this->sendRequest('GET', 'getUpdates', [
            'offset'  => $offset,
            'limit'   => $limit,
            'timeout' => $timeout
        ]);
    }
}