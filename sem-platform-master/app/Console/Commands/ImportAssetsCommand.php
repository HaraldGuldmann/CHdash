<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\ContentOwner;

class ImportAssetsCommand extends BaseYouTubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:import-assets';

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
     * @return void
     */
    public function handle()
    {
        ContentOwner::active()->get()->each(function ($contentOwner) {
            $this->importAssetFor($contentOwner);
        });

        Asset::all()->chunk(50)->each(function($assets) {
            $this->updateAssets($assets);
        });
    }

    private function importAssetFor($contentOwner, $nextPage = null)
    {
        $bar = null;

        try {
            $this->paginate(function ($pageToken) use ($contentOwner, &$bar) {
                $response = $this->partner->assetSearch->listAssetSearch([
                    'onBehalfOfContentOwner' => $contentOwner->external_id,
                    'ownershipRestriction' => 'mine',
                    'pageToken' => $pageToken,
                ]);

                if(is_null($bar))
                {
                    $bar = $this->output->createProgressBar(
                        $response->getPageInfo()->getTotalResults()
                    );

                    $bar->start();
                }

                foreach ($response->getItems() as $asset) {
                    Asset::updateOrCreate(['youtube_id' => $asset->id], [
                        'type' => $asset->type,
                        'content_owner_id' => $contentOwner->id
                    ]);

                    $bar->advance();
                }

                return $response['nextPageToken'];
            });
        } catch (\Exception $e) {
            return;
        }

        $bar->finish(); $this->line(PHP_EOL);
    }

    private function updateAssets($assets)
    {
        $assets = $this->partner->assets->listAssets(
            implode(',', $assets->pluck('youtube_id')->toArray()
        ), [
            'fetchMetadata' => 'mine',
            'fetchOwnership' => 'mine'
        ]);

        foreach ($assets->getItems() as $asset) {
            Asset::where('youtube_id', $asset->id)->update([
                'status' => $asset->getStatus(),
                'alias_ids' => (array) $asset->getAliasId(),
                'metadata' => (array) optional($asset->getMetadataMine())->toSimpleObject(),
                'ownership' => (array) optional($asset->getOwnershipMine())->toSimpleObject(),
                'ownership_conflicts' => (array) optional($asset->getOwnershipConflicts())->toSimpleObject(),
            ]);
        }
    }
}
