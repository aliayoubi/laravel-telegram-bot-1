<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedStickerMessage extends AdvancedMessage
{
    /** @var string */
    protected $sticker = '';

    /**
     * Adds a sticker to the advanced message.
     *
     * @param  string $sticker
     *
     * @return static
     */
    public function sticker(string $sticker)
    {
        $this->sticker = $sticker;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendSticker($this->user, $this->sticker, $this->options);
    }
}