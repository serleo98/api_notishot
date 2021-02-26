<?php

namespace App\Console\Commands\Make;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class EntityMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new BaseEntity on project entities folder.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Entity';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return;
        }

        if ($this->option('all') || $this->option('default')) {
            if ($this->option('all')) {
                $this->input->setOption('factory', true);
                $this->input->setOption('migration', true);
            }
            $this->input->setOption('controller', true);
            $this->input->setOption('resource', true);
            $this->input->setOption('repository-service', true);
        }

        if ($this->option('small')) {
            $this->input->setOption('migration', true);
            $this->input->setOption('resource', true);
            $this->input->setOption('factory', true);
        }

        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('controller')) {
            $this->createController();
        }

        if ($this->option('resource')) {
            $this->createResource();
        }

        if ($this->option('repository-service')) {
            $this->createRepository();
            $this->createService();
        }
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => "Entities/" . $this->argument('name'),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $namespace = $this->getCustomNamespace();

        $this->call('make:api-controller', [
            'name' => "{$namespace}/{$controller}Controller",
            '--model' => $this->option('restful') ? $modelName : null,
            '--api' => true
        ]);
    }

    /**
     * Create a resource for the model.
     *
     * @return void
     */
    protected function createResource()
    {
        $resource = Str::studly(class_basename($this->argument('name')));

        $namespace = $this->getCustomNamespace();

        $this->call('make:resource', [
            'name' => "{$namespace}/{$resource}Resource",
        ]);
    }

    /**
     * Create a repository for the model.
     *
     * @return void
     */
    protected function createRepository()
    {
        $repository = Str::studly($this->argument('name'));

        $this->call('make:repository', [
            'name' => $repository,
            '--interface' => true,
        ]);
    }

    /**
     * Create a service for the model.
     *
     * @return void
     */
    protected function createService()
    {
        $service = Str::studly($this->argument('name'));

        $this->call('make:service', [
            'name' => $service,
            '--interface' => true,
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return __DIR__ . '/stubs/pivot.model.stub';
        }

        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Entities';
    }

    protected function getCustomNamespace()
    {
        return $this->getNamespace(str_replace('/', '\\', $this->getNameInput()));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, factory, repository and service, laravel resource and controller for the entity'],

            ['small', 'sm', InputOption::VALUE_NONE, 'Generate a migration, factory, and laravel resource for the entity'],

            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new resource controller for the entity in the api namespace'],

            ['default', 'd', InputOption::VALUE_NONE, 'Generate a repository, service, laravel-resource and controller for the entity'],

            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the entity'],

            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the entity already exists'],

            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the entity'],

            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated entity should be a custom intermediate table entity'],

            ['repository-service', 's', InputOption::VALUE_NONE, 'Create a new repository and bind it to a service for the entity'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Create a new laravel resource for the entity'],

            ['restful', 't', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a restful controller'],

        ];
    }
}
