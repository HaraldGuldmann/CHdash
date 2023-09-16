<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class YouTubeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube';

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
        $this->info('youtube:import-content-owners');
        $this->call(ImportContentOwnersCommand::class);
        $this->info('youtube:import-channels');
        $this->call(ImportChannelsCommand::class);
        $this->info('youtube:import-assets');
        $this->call(ImportAssetsCommand::class);
        $this->info('youtube:import-references');
        $this->call(ImportReferencesCommand::class);
        $this->info('youtube:import-asset-labels');
        $this->call(ImportAssetLabelsCommand::class);
    }
}
