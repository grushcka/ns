<?php

namespace NS\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:refresh-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh migrations from all modules';

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
     * @return void
     */
    public function handle(): void
    {
        $this->info('Refresh base migrations');
        Artisan::call('migrate:refresh');
        $modules = array_diff(scandir(app_path('Http/Modules')), ['.', '..']);
        foreach ($modules as $module) {
            $this->info(sprintf('Scan module: %s', $module));
            $migrationsDir = "Http/Modules/{$module}/DB/migrations";
            if (is_dir(app_path($migrationsDir))) {
                $this->info(sprintf('Start refresh migrations module: %s', $module));
                Artisan::call('migrate:refresh', ['--path' => 'app/'.$migrationsDir]);
            }
        }
    }
}
