<?php

namespace App\Console\Commands;

use App\Jobs\ParseEarningRunJob;
use App\Jobs\ParseReportJob;
use App\Models\EarningRun;
use Illuminate\Console\Command;

class ParseEarningRunsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earningruns:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse all the locked earning runs.';

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
        foreach (EarningRun::where('locked', true)->get() as $earningrun) {
            foreach ($earningrun->reports as $report) {
                ParseReportJob::dispatch($report);
            }
        }
    }
}
