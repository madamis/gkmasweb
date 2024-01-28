<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreatePageComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-page-component {name}';

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
        $componentName = $this->argument('name');
        $this->call("make:component",["name"=>$componentName]);
        $stub = $this->files->get('stubs/v1/components/page.header.stub');
        $viewStub = $this->files->get('stubs/v1/components/page-header.blade.stub');
        $componentPath = app_path('View/Components/PageHeader.php');
        $viewPath = resource_path('views/components/page-header.blade.php');
        $this->files->put($componentPath, $stub);
        $this->files->put($viewPath, $viewStub);
        $this->info($componentPath."..............DONE");
    }
}
