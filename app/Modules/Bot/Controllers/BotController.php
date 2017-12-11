<?php

namespace RadioBot\Modules\Bot\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RadioBot\Http\Controllers\Controller;
use RadioBot\Modules\Bot\Contracts\BotContract;
use RadioBot\Modules\Bot\Factories\BotFactory;

class BotController extends Controller
{
    /**
     * All incoming web hook request.
     *
     * @param Request $request
     */
    public function webhook(Request $request)
    {
        Log::info('Incoming payload', $request->all());

        /** @var BotFactory $botFactory */
        $botFactory = app(BotFactory::class);

        /** @var BotContract $bot */
        $bot = $botFactory->make('radio', $request->all());

        $bot->run();
    }
}