<?php

namespace App\Console\Commands;


class InstallShop extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Initialize Command';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('db:seed');

        // create a symbolic link from public/storage to storage/app/public
        Storage::makeDirectory('public');
        $this->call('storage:link');
    }
}
