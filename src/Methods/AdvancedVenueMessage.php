<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedVenueMessage extends AdvancedMessage
{
    /** @var float */
    protected $latitude = 0;

    /** @var float */
    protected $longitude = 0;

    /** @var string */
    protected $title = '';

    /** @var string */
    protected $address = '';

    /**
     * Sets the latitude of the venue.
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
     * Alias to set the latitude of the venue.
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
     * Sets the longitude of the venue.
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
     * Alias to set the longitude of the venue.
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
     * Sets the title of the venue.
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
     * Sets the address of the venue.
     *
     * @param  string $address
     *
     * @return static
     */
    public function address(string $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Sets the foursquare id of the venue.
     *
     * @param  string $foursquare_id
     *
     * @return static
     */
    public function foursquareId(string $foursquare_id)
    {
        $this->options['foursquare_id'] = $foursquare_id;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendVenue($this->chat, $this->latitude, $this->longitude, $this->title, $this->address, $this->options);
    }
}