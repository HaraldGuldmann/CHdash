<?php

namespace App\Traits;

trait GooglePaginationTrait
{
    /**
     * Paginate through an API response
     *
     * @param callable $callback
     * @throws \Exception
     */
    public function paginate(callable $callback)
    {
        $pageToken = null;
        $oldPageToken = null;

        do {
            $pageToken = is_null($oldPageToken) ? $pageToken : $oldPageToken;

            try {
                $pageToken = call_user_func($callback, $pageToken);

                unset($error_count);
            }
            catch(\Google_Service_Exception $e) {
                if( ! isset($error_count)) {
                    $error_count = 0;
                }

                $error_count++;

                if($error_count > 8) {
                    throw new \Exception('GooglePagination: Too many tries');
                }

                $oldPageToken = $pageToken;
                time_nanosleep(pow(2, $error_count), rand(1000000, 1000000000));
            }
        } while($pageToken !== null);
    }
}
