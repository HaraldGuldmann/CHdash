<?php

namespace App\Console\Commands;

use App\Jobs\ImportAssetLabelsJob;
use App\Jobs\ImportChannelsJob;
use App\Models\Channel;
use App\Models\ContentOwner;

class ImportChannelsCommand extends BaseYouTubeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:import-channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves a list of channels managed by the specified YouTube content owner.';

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
        ContentOwner::active()->each(function($contentOwner) {
            $this->paginate(function ($pageToken) use($contentOwner) {
                $response = $this->data->channels->listChannels('snippet,statistics,contentOwnerDetails', [
                    'managedByMe' => true,
                    'maxResults' => 50,
                    'pageToken' => $pageToken,
                    'onBehalfOfContentOwner' => $contentOwner->external_id
                ]);

                foreach ($response->getItems() as $channel) {
                    Channel::updateOrCreate(['external_id' => $channel->id], [
                        'name' => $channel->snippet->title,
                        'avatar' => $channel->snippet->thumbnails->high->url,
                        'statistics' => $channel->statistics,
                        'content_owner_id' => $contentOwner->id,
                        //'linked_at' => Carbon::parse($channel->contentOwnerDetails->timeLinked)
                        'linked_at' => now()
                    ]);
                }

                return $response['nextPageToken'];
            });
        });
    }
}
