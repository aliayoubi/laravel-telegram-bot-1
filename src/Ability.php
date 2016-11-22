<?php

namespace SumanIon\TelegramBot;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    /** @var string */
    protected $table = 'telegram_bot_abilities';

    /** @var array */
    protected $fillable = [
        'name'
    ];

    /**
     * Returns ids of given ability names.
     *
     * @param  string|array $abilities
     *
     * @return array
     */
    public static function ids($abilities):array
    {
        return (new Collection((array)$abilities))->map(function ($ability) {
            return static::firstOrCreate(['name' => (string)$ability])->id;
        })->all();
    }
}