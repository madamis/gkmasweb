<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateGkmasController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-gkmas-controller {name} {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controllerName = $this->argument('name');
        $modelName = $this->argument('model');
        $smallModelName = strtolower($this->argument('model'));

        $controllerPath = app_path('Http/Controllers/' . $controllerName . '.php');

        if ($this->files->exists($controllerPath)) {
            $this->error("Controller '{$controllerName}' already exists!");
            return;
        }

        $stub = $this->files->get('stubs/v1/controller.stub');

        $stub = str_replace('{{controllerName}}', $controllerName, $stub);
        $stub = str_replace('{{ModelName}}', $modelName, $stub);
        $stub = str_replace('{{modelObject}}', Str::camel($modelName), $stub);
        $stub = str_replace('{{model_snake}}', Str::snake($smallModelName), $stub);

        $this->files->put($controllerPath, $stub);

        $this->info("Controller '{$controllerName}' created successfully.");
    }
}
