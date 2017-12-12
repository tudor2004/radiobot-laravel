<?php

namespace RadioBot\Modules\Bot\Containes;

/**
 * Container service that allows adding of bots.
 */
class BotContainer
{
    /**
     * @var Cron[][]
     */
    private $cronList = [];

    /**
     * @var array
     */
    private $cronMap = [];

    /**
     * Use this method to add a handler class and a schedule time for your desired cron event. The action will then be triggered according to the given schedule.
     *
     * @param int    $schedule     The number of minutes for which the cron action should be scheduled. Currently allowed are: 15, 20, 60 and 3600. You can also use constants like `CronContainer::EVERY_FIFTEEN_MINUTES`, `CronContainer::EVERY_TWENTY_MINUTES`, `CronContainer::HOURLY`, `CronContainer::DAILY`;
     * @param string $handlerClass The handler class that should be triggered when the cron event is launched. This class has to extend the CronHandler interface and implement the `handle()` method.
     */
    public function add($schedule, $handlerClass)
    {
        try
        {

            $this->cronMap[] = [
                'schedule'     => $schedule,
                'handlerClass' => $handlerClass
            ];
        }
        catch (\Exception $exc)
        {
        }
    }

    /**
     *
     */
    private function initCrons()
    {
        if (empty($this->cronList))
        {

            foreach ($this->cronMap as $cronData)
            {
                try
                {
                    CronValidator::validateOrFail(['schedule' => $cronData['schedule']]);
                    $cron = new Cron();
                    $handler = null;
                    $cron->setSchedule($cronData['schedule']);

                    $handler = \App::make($cronData['handlerClass']);

                    if (method_exists($handler, 'handle'))
                    {
                        $cron->setHandler($handler);

                        $this->cronList[$cronData['schedule']][$cronData['handlerClass']] = $cron;
                    }
                }
                catch (\Exception $exc)
                {
                }
            }

        }
    }

    /**
     * Get cron list for a given schedule.
     *
     * @param int $schedule
     * @return Cron[]
     * @internal
     * @Hidden()
     */
    public function getCronsForSchedule($schedule)
    {
        $this->initCrons();
        if (isset($this->cronList[$schedule]))
        {
            return $this->cronList[$schedule];
        }

        return [];
    }

    /**
     * Get a cron for a given key.
     *
     * @param string $key
     * @return Cron|null
     * @internal
     * @Hidden()
     */
    public function getCronByKey($key)
    {
        $this->initCrons();
        return collect($this->cronList)
            ->collapse()
            ->get($key);
    }

    /**
     * Get the list of available schedules.
     *
     * @return array
     * @internal
     * @Hidden()
     */
    public function listSchedules()
    {
        return [
            self::EVERY_FIFTEEN_MINUTES,
            self::EVERY_TWENTY_MINUTES,
            self::HOURLY,
            self::DAILY,
        ];
    }
}
