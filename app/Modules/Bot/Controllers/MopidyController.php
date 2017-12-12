<?php

namespace RadioBot\Modules\Bot\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RadioBot\Http\Controllers\Controller;

class MopidyController extends Controller
{
    public function execute(Request $request)
    {
        $client = new Client();

        $res = $client->post('http://1270.0.0.1:6680/mopidy/rpc', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => $request->all()
        ]);

        return $res;
    }
}