<?php

namespace SumanIon\TelegramBot;

abstract class Manager
{
    use Features\FindsManagerUsingToken;
    use Features\ManagesChats;
    use Features\SendsApiRequests;
    use Features\RegistersApiMethods;
    use Features\ManagesUpdates;

    /**
     * Returns Access Token of the Bot.
     *
     * @return string
     */
    abstract public function token();

    /**
     * Returns FQCN of the Bot manager.
     *
     * @param  bool   $full
     *
     * @return string
     */
    public function name(bool $full = true):string
    {
        $namespace = get_class($this);

        if ($full) {
            return $namespace;
        }

        $namespace = explode('\\', $namespace);

        return end($namespace);
    }
}