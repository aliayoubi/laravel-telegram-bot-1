<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\Ability;

trait ManagesUserAbilities
{
    /**
     * A user may have many abilities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'telegram_bot_user_abilities', 'user_id', 'ability_id');
    }

    /**
     * Determines if a user has specific abilities.
     *
     * @param  string|array $abilities
     * @param  bool         $strict
     *
     * @return bool
     */
    public function can($abilities, bool $strict = false):bool
    {
        $abilities = (array)$abilities;
        $match     = function ($ability) use ($abilities) {
            return in_array($ability->name, $abilities);
        };

        if ($strict) {
            return count($abilities) === count($this->abilities->filter($match));
        }

        return false !== $this->abilities->search($match);
    }

    /**
     * Adds new abilities to a user.
     *
     * @param  string|array $abilities
     *
     * @return void
     */
    public function allowTo($abilities)
    {
        $this->abilities()->syncWithoutDetaching(Ability::ids($abilities));
        $this->load('abilities');
    }

    /**
     * Removes abilities from a user.
     *
     * @param  string|array $abilities
     *
     * @return void
     */
    public function denyTo($abilities)
    {
        $this->abilities()->detach(Ability::ids($abilities));
        $this->load('abilities');
    }
}