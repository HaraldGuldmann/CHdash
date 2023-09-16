<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;


/**
 * @method static self audiovisual()
 * @method static self visual()
 * @method static self audio()
 */
final class ReferenceContentTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'audio'       => 'Audio',
            'audiovisual' => 'Audio-Visual',
            'visual'      => 'Visual',
        ];
    }
}
