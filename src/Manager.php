<?php

namespace SumanIon\TelegramBot;

abstract class Manager
{
    use Features\FindsManagerUsingToken;
    use Features\ManagesUsers;
    use Features\SendsApiRequests;
    use Features\RegistersApiMethods;
    use Features\ManagesUpdates;

    /**
     * Returns Access Token of the Bot.
     *
     * @return string
     */
    abstract public function token();
}