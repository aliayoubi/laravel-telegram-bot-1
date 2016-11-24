<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedPhotoMessage extends AdvancedMessage
{
    /** @var string */
    protected $photo = '';

    /** @var string */
    protected $caption = '';

    /**
     * Adds a photo to the advanced message.
     *
     * @param  string $photo
     *
     * @return static
     */
    public function photo(string $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Adds a photo caption to the advanced message.
     *
     * @param  string $caption
     *
     * @return static
     */
    public function caption(string $caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Handle the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendPhoto($this->user, $this->photo, $this->caption, $this->options);
    }
}