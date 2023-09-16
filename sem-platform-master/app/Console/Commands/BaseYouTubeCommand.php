<?php

namespace App\Console\Commands;

use App\Providers\YouTubeServiceProvider;
use App\Traits\GooglePaginationTrait;
use Google_Service_YouTube;
use Google_Service_YouTubePartner;
use Illuminate\Console\Command;

abstract class BaseYouTubeCommand extends Command
{
    use GooglePaginationTrait;

    protected Google_Service_YouTubePartner $partner;
    protected Google_Service_YouTube $data;

    public function __construct()
    {
        $google = app(YouTubeServiceProvider::GOOGLE_SERVICECLIENT);

        $this->partner = new Google_Service_YouTubePartner(
            $google
        );

        $this->data = new Google_Service_YouTube(
            $google
        );

        parent::__construct();
    }
}
