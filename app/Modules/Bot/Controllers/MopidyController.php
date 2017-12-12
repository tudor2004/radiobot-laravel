<?php

namespace RadioBot\Modules\Bot\Controllers;

use Illuminate\Http\Request;
use RadioBot\Http\Controllers\Controller;

class MopidyController extends Controller
{
    public function execute(Request $request)
    {
        $cmd = 'curl -X POST -H Content-Type:application/json -d \'' . json_encode($request->all()) . '\' http://127.0.0.1:6680/mopidy/rpc';
        shell_exec($cmd);
    }
}