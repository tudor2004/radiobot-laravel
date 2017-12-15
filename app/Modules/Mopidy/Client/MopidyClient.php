<?php

namespace RadioBot\Modules\Mopidy\Client;

use GuzzleHttp\Client;

/**
 * Class MopidyClient
 *
 * A very simple client that allows us to send requests to a mopidy service.
 */
class MopidyClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * MopidyClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Call mopidy.
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function call(array $data)
    {
        $data['jsonrpc'] = '2.0';

        $response = $this->client->post(config('mopidy.host') .':' . config('mopidy.port') . '/mopidy/rpc', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $data
        ]);

        if($response->getStatusCode() !== 200)
        {
            throw new \Exception('Tra la la... something wen\'t wrong as I wanted to send your demand to the music player :(');
        }

        $result = \GuzzleHttp\json_decode($response->getBody(), true);

        return $result;
    }
}