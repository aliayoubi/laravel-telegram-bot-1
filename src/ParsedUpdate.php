<?php

namespace SumanIon\TelegramBot;

use stdClass;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use SumanIon\TelegramBot\Exceptions\UnknownUpdateId;
use SumanIon\TelegramBot\Exceptions\UnknownUpdateType;
use SumanIon\TelegramBot\Exceptions\UnknownUpdateChat;

class ParsedUpdate
{
    /** @var array */
    protected $update;

    /**
     * Creates a new parsed update.
     *
     * @param string $update
     */
    public function __construct(string $update)
    {
        $this->update = json_decode($update, true) ?: [];
    }

    /**
     * Returns the id of current update.
     *
     * @throws \SumanIon\TelegramBot\Exceptions\UnknownUpdateId
     *
     * @return int
     */
    public function id():int
    {
        $id = Arr::get($this->update, 'update_id');

        if (!$id) {
            throw new UnknownUpdateId($this->toJson());
        }

        return $id;
    }

    /**
     * Returns the type of current update.
     *
     * @throws \SumanIon\TelegramBot\Exceptions\UnknownUpdateType
     *
     * @return string|bool
     */
    public function type($expected = null)
    {
        $types = [
            'message',
            'edited_message',
            'channel_post',
            'edited_channel_post',
            'inline_query',
            'chosen_inline_result',
            'callback_query'
        ];

        $type = (new Collection($types))->first(function ($type) {
            return isset($this->update[$type]);
        });

        if (!$type) {
            throw new UnknownUpdateType($this->toJson());
        }

        if ($expected) {
            return in_array($type, (array)$expected);
        }

        return $type;
    }

    /**
     * Returns information about the user who initiated the update.
     *
     * @return null|stdClass
     */
    public function from()
    {
        $type = $this->type();
        $from = $this->update[$type]['from'] ?? null;

        if (!$from or !isset($from['id'])) {
            return null;
        }

        return (object)[
            'id'         => $from['id'],
            'first_name' => $from['first_name'] ?? null,
            'last_name'  => $from['last_name'] ?? null,
            'username'   => $from['username'] ?? null
        ];
    }

    /**
     * Returns information about the chat who initiated the update.
     *
     * @throws \SumanIon\TelegramBot\Exceptions\UnknownUpdateChat
     *
     * @return stdClass
     */
    public function chat():stdClass
    {
        $chat = $this->update[$this->type()]['chat'] ?? null;

        if (!$chat or !isset($chat['id']) or !isset($chat['type'])) {
            throw new UnknownUpdateChat($this->toJson());
        }

        return (object)[
            'id'    => $chat['id'],
            'type'  => $chat['type'],
            'title' => $chat['title'] ?? null
        ];
    }

    /**
     * Returns a value from the update.
     *
     * @param  string $path
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        return Arr::get($this->update, $path, $default);
    }

    /**
     * Converts current update to a JSON string.
     *
     * @return string
     */
    public function toJson():string
    {
        return json_encode($this->update);
    }
}