<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    /** @var string */
    protected $table = 'telegram_bot_updates';

    /** @var array */
    protected $fillable = [
        'manager',
        'chat_id',
        'content'
    ];

    /** @var null|\SumanIon\TelegramBot\ParsedUpdate */
    protected $parsedUpdate;

    /**
     * Converts update content to ParsedUpdate object.
     *
     * @param  string $content
     *
     * @return \SumanIon\TelegramBot\ParsedUpdate
     */
    public function getContentAttribute($content)
    {
        return $this->parsedUpdate ? $this->parsedUpdate : ($this->parsedUpdate = new ParsedUpdate($content));
    }
}