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
     * Sets the caption of the photo.
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
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendPhoto($this->chat, $this->photo, $this->caption, $this->options);
    }
}