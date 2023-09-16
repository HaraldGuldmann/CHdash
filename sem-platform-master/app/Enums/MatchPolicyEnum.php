<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self monetize()
 * @method static self track()
 * @method static self block()
 * @method static self takedown()
 */
final class MatchPolicyEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'track'    => 'Track',
            'monetize' => 'Monetize',
            'block'    => 'Block',
            'takedown' => 'Takedown (DMCA)',
        ];
    }
}
