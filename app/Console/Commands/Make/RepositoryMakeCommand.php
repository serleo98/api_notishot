<?php

namespace App\Console\Commands\Make;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository with his interface';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'RepositoryInterface';

    /**
     * Sets to true when exists an interface
     *
     * @var bool
     */
    protected $hasInterface = false;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        if ($this->interface()) {
            $this->hasInterface = true;

            parent::handle();

            $this->input->setOption('interface', false);
        }

        $this->type = 'Repository';

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->interface()
            ? __DIR__ . '/stubs/interface.repository.stub'
            : __DIR__ . '/stubs/repository.stub';
    }

    /**
     * Determine if the command is generating a repository interface.
     *
     * @return bool
     */
    protected function interface()
    {
        return $this->option('interface');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->interface()) {
            return $rootNamespace . '\Interfaces\Repositories';
        } else {
            return $rootNamespace . '\Repositories';
        }
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        if ($this->interface()) {
            return trim($this->argument('name')) . 'RepositoryInterface';
        } else {
            return trim($this->argument('name')) . 'Repository';
        }
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = $this->buildReplacements();

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the repository replacement values.
     *
     * @return array
     */
    protected function buildReplacements()
    {
        $class = trim(str_replace('/', '\\', trim($this->argument('name'))), '\\');

        $interfaceClass = $class . 'RepositoryInterface';
        $interfaceNamespace = 'App\\Interfaces\\Repositories\\' . str_replace('\\' . class_basename($interfaceClass), '', $interfaceClass);

        return [
            'DummyFullEntityClass' => 'App\\Entities\\' . $class,
            'DummyFullInterfaceClass' => $this->hasInterface ? $interfaceNamespace . '\\' . class_basename($interfaceClass) : '',
            'DummyImplementsInterfaceClass' => $this->hasInterface ? "implements " . class_basename($interfaceClass) : '',
            'DummyInterfaceNamespace' => $interfaceNamespace,
            'DummyInterfaceClass' => class_basename($interfaceClass),
            'DummyEntityClass' => class_basename($class),
            'DummyEntityVariable' => lcfirst(class_basename($class)),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['interface', 'i', InputOption::VALUE_NONE, 'Create an interface for the repository'],
        ];
    }
}
