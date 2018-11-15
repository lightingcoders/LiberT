<?php

namespace HolluwaTosin\Installer\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class FreshInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs necessary cleanup, for a fresh installation.';

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
     */
    public function handle()
    {
        $this->deleteFiles();
        $this->deleteVariables();
        $this->wipeDirectories();

        $this->info('Done!');
    }

    public function deleteFiles()
    {
        File::delete(storage_path('installed'));
        File::delete(base_path('.env'));
    }

    public function deleteVariables()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Session::flush();
    }

    public function wipeDirectories()
    {
        File::deleteDirectory(storage_path('users'));
        File::deleteDirectory(storage_path('email-previews'));
        File::deleteDirectory(storage_path('app/trade'));
    }
}
