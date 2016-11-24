<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedVideoMessage extends AdvancedMessage
{
    /** @var string */
    protected $video = '';

    /** @var string */
    protected $caption = '';

    /**
     * Adds a video file to the advanced message.
     *
     * @param  string $video
     *
     * @return static
     */
    public function video(string $video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Sets the caption of the video file.
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
     * Sets the duration of the video file.
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
     * Sets the width of the video file.
     *
     * @param  int    $width
     *
     * @return static
     */
    public function width(int $width)
    {
        $this->options['width'] = $width;

        return $this;
    }

    /**
     * Sets the height of the video file.
     *
     * @param  int    $height
     *
     * @return static
     */
    public function height(int $height)
    {
        $this->options['height'] = $height;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendVideo($this->user, $this->video, $this->caption, $this->options);
    }
}