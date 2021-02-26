<?php

namespace App\Console\Commands\Feed;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class Modules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:modules
                            {--a|admin : Append all the modules to the admin profile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los modulos y los agrega al administrador';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->feedModules();

        if ($this->hasOption('admin') && $this->option('admin')) {
            $this->appendToAdminProfile();
        }
    }

    /**
     * Feed all modules con config/custom/modules
     *
     * @return void
     */
    protected function feedModules()
    {
        $this->call('db:seed', [
            '--class' => 'ModulesSeeder',
        ]);
    }

    /**
     * Add all modules to the admin profile
     *
     * @return void
     */
    protected function appendToAdminProfile()
    {
        $this->call('db:seed', [
            '--class' => 'ProfileSubModulesTableSeeder',
        ]);
    }

}
