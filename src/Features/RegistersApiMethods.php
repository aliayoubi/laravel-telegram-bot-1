<?php

namespace SumanIon\TelegramBot\Features;

use Illuminate\Support\Facades\Queue;
use SumanIon\TelegramBot\ParsedUpdate;
use SumanIon\TelegramBot\Jobs\SendRequest;
use SumanIon\TelegramBot\Methods\AdvancedMessage;

trait RegistersApiMethods
{
    /**
     * Returns basic information about current bot.
     *
     * @return \SumanIon\TelegramBot\ParsedUpdate
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

    /**
     * Specifies an url to receive incoming updates via an outgoing webhook.
     *
     * @param  string|null $url
     *
     * @return \SumanIon\TelegramBot\ParsedUpdate
     */
    public function setWebhook(string $url = null):ParsedUpdate
    {
        return current($this->sendRequest('GET', 'setWebhook', [
            'url' => $url
        ]));
    }

    /**
     * Returns information about current status of webhook.
     *
     * @return \SumanIon\TelegramBot\ParsedUpdate
     */
    public function getWebhookInfo():ParsedUpdate
    {
        return current($this->sendRequest('GET', 'getWebhookInfo'));
    }

    /**
     * Sends a message to a bot user.
     *
     * @param  mixed       $user
     * @param  string|null $text
     * @param  array       $options
     *
     * @return void
     */
    public function sendMessage($user, string $text = null, array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedMessage($this, $user);
        }

        $options['chat_id'] = $this->chatId($user);
        $options['text']    = $text;
        $url                = $this->url('sendMessage', $options);

        Queue::push(new SendRequest('GET', $url));
    }
}