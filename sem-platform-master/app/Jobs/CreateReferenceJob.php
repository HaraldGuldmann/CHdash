<?php

namespace App\Jobs;

use App\Enums\VideoStatusEnum;
use App\Models\ContentOwner;
use App\Models\Video;
use App\Providers\YouTubeServiceProvider;
use Google_Http_MediaFileUpload;
use Google_Service_YouTubePartner;
use Google_Service_YouTubePartner_Asset;
use Google_Service_YouTubePartner_AssetMatchPolicy;
use Google_Service_YouTubePartner_Conditions;
use Google_Service_YouTubePartner_Metadata;
use Google_Service_YouTubePartner_PolicyRule;
use Google_Service_YouTubePartner_Reference;
use Google_Service_YouTubePartner_RightsOwnership;
use Google_Service_YouTubePartner_TerritoryCondition;
use Google_Service_YouTubePartner_TerritoryOwners;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateReferenceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $contentOwnerId;
    protected Video $video;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
        $this->contentOwnerId = ContentOwner::first()->external_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $partner = new Google_Service_YouTubePartner(
            $googleClient = app(YouTubeServiceProvider::GOOGLE_SERVICECLIENT)
        );

        $metadata = new Google_Service_YouTubePartner_Metadata();
        $metadata->setTitle($this->video->name . ' ' . $this->video->id);
        $metadata->setDescription($this->video->description);
        //$metadata->setLabel(Str::slug($this->video->user->name));

        $asset = new Google_Service_YouTubePartner_Asset();
        $asset->setMetadata($metadata);
        $asset->setType("web");

        $assetId = $partner->assets->insert($asset, [
            'onBehalfOfContentOwner' => $this->contentOwnerId
        ])['id'];

        $owners = new Google_Service_YouTubePartner_TerritoryOwners();
        $owners->setOwner($this->contentOwnerId);
        $owners->setRatio(100);
        $owners->setType("exclude");
        $owners->setTerritories([]);

        $ownership = new Google_Service_YouTubePartner_RightsOwnership();
        $ownership->setGeneral([$owners]);

        $partner->ownership->update($assetId, $ownership, ['onBehalfOfContentOwner' => $this->contentOwnerId]);

        $requiredTerritories = new Google_Service_YouTubePartner_TerritoryCondition();
        $requiredTerritories->setTerritories(collect((new \League\ISO3166\ISO3166))->pluck('alpha2')->toArray());
        $requiredTerritories->setType("include");

        $everywherePolicyCondition = new Google_Service_YouTubePartner_Conditions();
        $everywherePolicyCondition->setContentMatchType(['video']); // TODO
        $everywherePolicyCondition->setRequiredTerritories($requiredTerritories);
        $everywherePolicyCondition->setReferenceDuration(["low" => 10]);

        $trackEverywhereRule = new Google_Service_YouTubePartner_PolicyRule();
        $trackEverywhereRule->setAction('monetize'); // TODO
        $trackEverywhereRule->setConditions($everywherePolicyCondition);

        $assetMatchPolicy = new Google_Service_YouTubePartner_AssetMatchPolicy();
        $assetMatchPolicy->setRules([$trackEverywhereRule]);

        $partner->assetMatchPolicy->update(
            $assetId,
            $assetMatchPolicy,
            ['onBehalfOfContentOwner' => $this->contentOwnerId]
        );

        $chunkSizeBytes = 1 * 4196 * 4196;

        $googleClient->setDefer(true);

        $reference = new Google_Service_YouTubePartner_Reference();
        $reference->setAssetId($assetId);
        $reference->setContentType("audiovisual");

        $insertRequest = $partner->references->insert($reference, ['onBehalfOfContentOwner' => $this->contentOwnerId]);


        $media = new Google_Http_MediaFileUpload(
            $googleClient,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );

        $media->setFileSize(filesize(storage_path('app/public/') . $this->video->file_path));

        $status = false;
        $handle = fopen(storage_path('app/public/') . $this->video->file_path, "rb");

        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }

        fclose($handle);

        $googleClient->setDefer(false);

        $this->video->update(['status' => VideoStatusEnum::approved()]);
    }
}
