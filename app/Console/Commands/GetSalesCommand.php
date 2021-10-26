<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Scripts\SalesScript;

class GetSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:get {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get sales by year';

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
        $script = new SalesScript();
        $this->info('working...');
        $result = $script->getOrdersList($this->option('year') ?? 2021);
        return $result;
    }
}
