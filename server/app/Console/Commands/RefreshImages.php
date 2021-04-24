<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\ImageController;

class RefreshImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refreshImages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $controller = new ImageController;
        $controller->refresh();
        return 0;
    }
}
