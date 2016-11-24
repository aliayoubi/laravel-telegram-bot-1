<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedVoiceMessage extends AdvancedMessage
{
    /** @var string */
    protected $voice = '';

    /** @var string */
    protected $caption = '';

    /**
     * Adds a voice file to the advanced message.
     *
     * @param  string $voice
     *
     * @return static
     */
    public function voice(string $voice)
    {
        $this->voice = $voice;

        return $this;
    }

    /**
     * Sets the caption of the voice file.
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
     * Sets the duration of the voice file.
     *
     * @param  int    $duration
     *
     * @return static
     */
    public function duration(int $duration)
    {
        $this->options['duration'] = $duration;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendVoice($this->chat, $this->voice, $this->caption, $this->options);
    }
}