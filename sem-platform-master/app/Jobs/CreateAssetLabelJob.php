<?php

namespace App\Jobs;

use App\Models\AssetLabel;
use App\Models\ContentOwner;
use App\Models\User;
use Google_Service_YouTubePartner_AssetLabel;
use Google_Service_YouTubePartner;
use App\Providers\YouTubeServiceProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateAssetLabelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $youtubePartner = new Google_Service_YouTubePartner(
            app(YouTubeServiceProvider::GOOGLE_SERVICECLIENT)
        );

        $assetLabel = new Google_Service_YouTubePartner_AssetLabel();
        $assetLabel->setLabelName(Str::slug($this->user->name));

        $youtubePartner->assetLabels->insert($assetLabel, [
            'onBehalfOfContentOwner' => ContentOwner::first()->external_id
        ]);

        AssetLabel::firstOrCreate([
            'user_id' => $this->user->id,
            'content_owner_id' => ContentOwner::first()->id
        ], [
            'name' => Str::slug($this->user->name),
        ]);
    }
}
