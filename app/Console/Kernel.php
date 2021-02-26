<?php

namespace App\Console;

use App\Console\Commands\App\Install;
use App\Console\Commands\Feed\Modules;
use App\Console\Commands\Make\ApiControllerMakeCommand;
use App\Console\Commands\Make\EntityMakeCommand;
use App\Console\Commands\Make\RepositoryMakeCommand;
use App\Console\Commands\Make\ServiceMakeCommand;
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
        ApiControllerMakeCommand::class,
        EntityMakeCommand::class,
        RepositoryMakeCommand::class,
        ServiceMakeCommand::class,
        Modules::class,
        Install::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
