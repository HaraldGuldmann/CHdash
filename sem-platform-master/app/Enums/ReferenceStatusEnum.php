<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self activating()
 * @method static self active()
 * @method static self checking()
 * @method static self computing_fingerprint()
 * @method static self deleted()
 * @method static self inactive()
 * @method static self live_streaming_processing()
 * @method static self urgent_reference_processing()
 */
final class ReferenceStatusEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'activating' => 'The reference is pending',
            'active' => '',
            'checking' => 'The reference is being compared to existing references to identify any reference conflicts that might exist',
            'computing_fingerprint' => 'The reference\'s fingerprint is being computed',
            'deleted' => '',
            'inactive' => '',
            'live_streaming_processing' => 'The reference is being processed from a live video stream',
            'urgent_reference_processing' => '',
        ];
    }
}
