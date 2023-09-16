<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\ServiceProvider;

class YouTubeServiceProvider extends ServiceProvider
{
    const GOOGLE_SERVICECLIENT = 'GOOGLE_SERVICECLIENT';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(self::GOOGLE_SERVICECLIENT, function ($app): Google_Client {
            $googleClient = new Google_Client();
            $googleClient->setAuthConfig(storage_path(config('services.google.service_account')));
            $googleClient->setScopes([
                'https://www.googleapis.com/auth/youtube',
                'https://www.googleapis.com/auth/youtubepartner',
                'https://www.googleapis.com/auth/yt-analytics-monetary.readonly',
                'https://www.googleapis.com/auth/yt-analytics.readonly'
            ]);

            return $googleClient;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
