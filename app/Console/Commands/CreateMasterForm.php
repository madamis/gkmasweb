<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateMasterForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-master-form';

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
        $this->call("make:component",["name"=>"MasterForm"]);
        $this->call("make:component",["name"=>"TextField"]);
        $this->call("make:component",["name"=>"TextArea"]);

        $masterFormPath = app_path('View/Components/MasterForm.php');
        $masterViewPath = resource_path('views/components/master-form.blade.php');
        $this->files->put($masterFormPath, $this->files->get('stubs/v1/components/master-form.stub'));
        $this->files->put($masterViewPath, $this->files->get('stubs/v1/components/master-form.blade.stub'));

        $textFieldPath = app_path('View/Components/TextField.php');
        $textFieldViewPath = resource_path('views/components/text-field.blade.php');
        $this->files->put($textFieldPath, $this->files->get('stubs/v1/components/text-field.stub'));
        $this->files->put($textFieldViewPath, $this->files->get('stubs/v1/components/text-field.blade.stub'));

        $textAreaPath = app_path('View/Components/TextArea.php');
        $textAreaViewPath = resource_path('views/components/text-area.blade.php');
        $this->files->put($textAreaPath, $this->files->get('stubs/v1/components/text-area.stub'));
        $this->files->put($textAreaViewPath, $this->files->get('stubs/v1/components/text-area.blade.stub'));

        $this->info($masterFormPath."..............DONE");
    }
}
