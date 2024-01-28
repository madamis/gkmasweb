<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateSection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-section';

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
        $this->call("make:component",["name"=>"SectionHeader"]);
        $stub = $this->files->get('stubs/v1/components/section-header.stub');
        $viewStub = $this->files->get('stubs/v1/components/section-header.blade.stub');
        $componentPath = app_path('View/Components/SectionHeader.php');
        $viewPath = resource_path('views/components/section-header.blade.php');
        $this->files->put($componentPath, $stub);
        $this->files->put($viewPath, $viewStub);
        $this->info($componentPath."..............DONE");
    }
}
