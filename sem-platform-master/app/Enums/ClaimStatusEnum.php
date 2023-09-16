<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self pending()
 * @method static self claimed()
 * @method static self rejected()
 */
final class ClaimStatusEnum extends Enum
{
}
