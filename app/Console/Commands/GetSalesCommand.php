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
        //echo $this->option('year') ?? 2021;
        $script = new SalesScript();
        //$sales = $script->getOrder('1023441621348-01');
        $sales = $script->getOrdersList($this->option('year'));
        $this->info($sales);
        return 0;
    }
}
