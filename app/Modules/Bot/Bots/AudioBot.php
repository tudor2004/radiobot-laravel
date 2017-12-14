<?php

namespace RadioBot\Modules\Bot\Bots;

use RadioBot\Modules\Bot\Commands\AudioAddYoutubeTrack;
use RadioBot\Modules\Bot\Commands\AudioClearTracks;
use RadioBot\Modules\Bot\Commands\AudioCurrentVolume;
use RadioBot\Modules\Bot\Commands\AudioGetTracks;
use RadioBot\Modules\Bot\Commands\AudioHelp;
use RadioBot\Modules\Bot\Commands\AudioOffCommand;
use RadioBot\Modules\Bot\Commands\AudioOnCommand;
use RadioBot\Modules\Bot\Commands\AudioPlayTrackNumber;
use RadioBot\Modules\Bot\Commands\AudioStop;
use RadioBot\Modules\Bot\Commands\AudioVolume;
use RadioBot\Modules\Bot\Contracts\BotContract;

/**
 * Class AudioBot
 */
class AudioBot extends AbstractBot implements BotContract
{
    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'Radio';
    }

    /**
     * @inheritDoc
     */
    public function commands(): array
    {
        return [
            // AudioOnCommand::class,
            // AudioOffCommand::class,
            AudioAddYoutubeTrack::class,
            AudioPlayTrackNumber::class,
            AudioStop::class,
            AudioGetTracks::class,
            AudioClearTracks::class,
            AudioVolume::class,
            AudioCurrentVolume::class,
            AudioHelp::class,
        ];
    }

}