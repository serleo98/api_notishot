<?php

namespace App\Console\Commands\Make;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ApiControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:api-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a plain api controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'API Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = null;

        if ($this->option('model')) {
            $stub = '/stubs/controller.model.stub';
        } else if ($this->option('api')) {
            $stub = '/stubs/controller.api.stub';
        }

        $stub = $stub ?? '/stubs/controller.plain.stub';

        return __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\Api';
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
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        $replace = $this->buildApiReplacements($replace);

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the model replacement values.
     *
     * @param  array $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (!class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:entity', ['name' => $modelClass]);
            }
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Build the api replacement values.
     *
     * @param  array $replace
     * @return array
     */
    protected function buildApiReplacements(array $replace)
    {
        $class = str_replace('Controller', '', trim(str_replace('/', '\\', $this->getNameInput()), '\\'));

        $resourceClass = "{$class}Resource";
        $serviceClass = "{$class}Service";

        return array_merge($replace, [
            'DummyFullResourceClass' => 'App\\Http\\Resources\\' . $resourceClass,
            'DummyFullServiceClass' => 'App\\Services\\' . $serviceClass,
            'DummyServiceClass' => class_basename($serviceClass),
            'DummyServiceVariable' => lcfirst(class_basename($serviceClass)),
            'DummyResourceClass' => class_basename($resourceClass),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        $rootNamespace = $this->rootNamespace() . 'Entities\\' . '';

        if (!Str::startsWith($model, $rootNamespace)) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],
            ['api', 'a', InputOption::VALUE_NONE, 'Generate a restful api controller.'],
        ];
    }
}
