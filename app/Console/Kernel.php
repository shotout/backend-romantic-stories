<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // broadcast notif story
        $schedule->job((new \App\Jobs\StoryNotif)->onQueue(env('SUPERVISOR')))->everyTenMinutes();

        // broadcast notif ads
        $schedule->job((new \App\Jobs\AdsNotif)->onQueue(env('SUPERVISOR')))->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
