<?php

namespace SumanIon\TelegramBot\Jobs;

use GuzzleHttp\Client;
use SumanIon\TelegramBot\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRequest implements ShouldQueue
{
    /** @var string */
    protected $manager;

    /** @var string */
    protected $type;

    /** @var string */
    protected $url;

    /** @var array */
    protected $fields;

    /**
     * Creates a new job instance.
     *
     * @param string $manager
     * @param string $type
     * @param string $url
     * @param array  $fields
     */
    public function __construct(string $manager, string $type, string $url, array $fields = [])
    {
        $this->manager = $manager;
        $this->type    = $type;
        $this->url     = $url;
        $this->fields  = $fields;
    }

    /**
     * Executes the job.
     *
     * @return void
     */
    public function handle()
    {
        $fields = json_encode($this->fields);

        if (isset($this->fields['multipart'])) {

            $this->fields['multipart'] = (new Collection((array)$this->fields['multipart']))->map(function ($field) {

                $field['contents'] = fopen($field['contents'], 'r');

                return $field;
            })->all();
        }

        $response = (new Client( [ 'http_errors' => false ]))->request($this->type, $this->url, $this->fields);

        Request::create([
            'manager'  => $this->manager,
            'type'     => $this->type,
            'url'      => $this->url,
            'fields'   => $fields,
            'response' => (string)$response->getBody()
        ]);
    }
}
