<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateGKMASPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-gkmas-page {pageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate a single page similar to GKMAS web page with all its associated files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pageName = $this->argument('pageName');

        $this->info('Generating model...');
        $this->call('make:model', ['name'=>$pageName]);

        $this->info('Generating controller...');
        $this->call('make:controller', ['name' => $pageName.'Controller', '--model' => $pageName]);
//        $this->call('make:controller', [
//            'name' => $pageName . 'Controller',
//            '--resource' => true,
//        ]);
        $this->info('generating views');
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/index')]);
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/edit')]);
        $this->call('make:view', ['name' => Str::lower(Str::plural($pageName,2).'/show')]);

        $this->info('page generation done');
    }
}
