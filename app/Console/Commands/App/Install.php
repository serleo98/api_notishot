<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install 
                                        {--prod|produccion: importa todo para produccion}
                                        {--r|restart : Restart Project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the project';

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
        if ($this->option('restart')) {
            $this->migrateRefresh();
        } else {
            $this->migrate();
        }

        $this->installPassport();

        $this->dbSeed([]);

       // $this->feedModules();

        $this->info('Proyecto Instalado');
    }

    protected function migrate()
    {
        $this->call('migrate');
    }

    protected function migrateRefresh()
    {
        $this->call('migrate:refresh');
    }

    protected function installPassport()
    {
        $this->call('passport:install', [
            '--force' => true,
        ]);
    }

    protected function dbSeed(array $arguments)
    {
        $this->call('db:seed', $arguments);
    }


}
