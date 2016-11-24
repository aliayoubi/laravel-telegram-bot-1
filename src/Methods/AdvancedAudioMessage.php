<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedAudioMessage extends AdvancedMessage
{
    /** @var string */
    protected $audio = '';

    /** @var string */
    protected $caption = '';

    /** @var int */
    protected $duration;

    /** @var string */
    protected $performer;

    /** @var string */
    protected $title;

    /**
     * Adds an audio file to the advanced message.
     *
     * @param  string $audio
     *
     * @return static
     */
    public function audio(string $audio)
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * Sets the caption of the audio file.
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
     * Sets the duration of the audio file.
     *
     * @param  int    $duration
     *
     * @return static
     */
    public function duration(int $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Sets the performer of the audio file.
     *
     * @param  string $performer
     *
     * @return static
     */
    public function performer(string $performer)
    {
        $this->performer = $performer;

        return $this;
    }

    /**
     * Sets the title of the audio file.
     *
     * @param  string $title
     *
     * @return static
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        if ($this->duration) {
            $this->options['duration'] = $this->duration;
        }

        if ($this->performer) {
            $this->options['performer'] = $this->performer;
        }

        if ($this->title) {
            $this->options['title'] = $this->title;
        }

        $this->manager->sendAudio($this->user, $this->audio, $this->caption, $this->options);
    }
}