<?php

namespace App\Console;

use App\Console\Commands\ImportAssetLabelsCommand;
use App\Console\Commands\ImportChannelsCommand;
use App\Console\Commands\ImportContentOwnersCommand;
use App\Console\Commands\IngestApprovedVideosCommand;
use App\Console\Commands\ParseEarningRunsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('youtube:import-content-owners')->everyFifteenMinutes();
        $schedule->command('youtube:import-channels')->hourly();
        $schedule->command('youtube:import-asset-labels')->everyFifteenMinutes();
        $schedule->command('earningruns:parse')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php');
    }
}
