<?php

namespace App\Console\Commands;

use App\Jobs\ImportContentOwnersJob;
use App\Models\ContentOwner;

class ImportContentOwnersCommand extends BaseYouTubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:import-content-owners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves information about the content owners from service account. ';

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
        $contentOwners = $this->partner
            ->contentOwners
            ->listContentOwners(['fetchMine' => true])
            ->getItems();

        foreach ($contentOwners as $contentOwner) {
            ContentOwner::updateOrCreate(['external_id' => $contentOwner->id], [
                'name' => $contentOwner->displayName
            ]);
        }
    }
}
