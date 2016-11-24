<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedLocationMessage extends AdvancedMessage
{
    /** @var float */
    protected $latitude = 0;

    /** @var float */
    protected $longitude = 0;

    /**
     * Sets the latitude of the location.
     *
     * @param  float  $latitude
     *
     * @return static
     */
    public function latitude(float $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Alias to set the latitude of the location.
     *
     * @param  float  $lat
     *
     * @return static
     */
    public function lat($lat)
    {
        return $this->latitude($lat);
    }

    /**
     * Sets the longitude of the location.
     *
     * @param  float  $longitude
     *
     * @return static
     */
    public function longitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Alias to set the longitude of the location.
     *
     * @param  float  $long
     *
     * @return static
     */
    public function long($long)
    {
        return $this->longitude($long);
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendLocation($this->chat, $this->latitude, $this->longitude, $this->options);
    }
}