<?php

namespace App\Console\Commands;

use App\Jobs\ImportAssetLabelsJob;
use App\Models\AssetLabel;
use App\Models\ContentOwner;

class ImportAssetLabelsCommand extends BaseYouTubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:import-asset-labels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves a list of asset labels for a content owner.';

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
     * @throws \Exception
     */
    public function handle()
    {
        ContentOwner::active()->each(function($contentOwner){
            $response = $this->partner->assetLabels->listAssetLabels([
                'onBehalfOfContentOwner' => $contentOwner->external_id
            ]);

            foreach ($response->getItems() as $assetLabel) {
                AssetLabel::updateOrCreate(['name' => $assetLabel->labelName], [
                    'content_owner_id' => $contentOwner->id
                ]);
            }
        });
    }
}
