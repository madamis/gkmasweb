<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-page {pageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate a single page similar to GKMAS web page with all its associated files.';

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
        $pageName = $this->argument('pageName');

        $this->info('Generating model...');
        $this->call('make:model', ['name'=>$pageName]);
        $this->call('make:migration', ['name'=>"create".Str::plural($pageName)."_table"]);

        $this->info('Generating controller...');
        //generating application controller
        $controllerPath = app_path('Http/Controllers/ApplicationController.php');

        if (!$this->files->exists($controllerPath)) {
            $stub = $this->files->get('stubs/v1/application.stub');
            $this->files->put($controllerPath, $stub);
            $this->info("{$controllerPath}................Done");
        }
        //end generating application controller
        $this->call('app:create-gkmas-controller', ['name' => $pageName.'Controller', 'model' => $pageName]);

        $this->info('generating views');
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/index')]);
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/edit')]);
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/show')]);
        $this->info('resource route');
        $resourcefulRoute = 'Route::resource("'.Str::plural(Str::camel($pageName)).'", App\Http\Controllers\\'.$pageName.'Controller::class);';
        $routesPath = app_path("../routes/web.php");
        file_put_contents($routesPath, $resourcefulRoute . PHP_EOL, FILE_APPEND | LOCK_EX);
        $this->info('page generation done');
    }
}
