<?php

namespace RadioBot\Modules\Bot\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RadioBot\Http\Controllers\Controller;
use RadioBot\Modules\Bot\Bots\AudioBot;

class BotController extends Controller
{
    /**
     * All incoming web hook request.
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function webhook(Request $request)
    {
        Log::info('Incoming payload:', $request->all());

        Log::info('Incoming headers', $request->header());

        try
        {
            return \GoogleBot::run(AudioBot::class, $request->all());

        }
        catch(\Exception $ex)
        {
            Log::err('Bot does not exists.', $ex);
        }
    }
}