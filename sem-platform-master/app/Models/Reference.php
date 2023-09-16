<?php

namespace App\Models;

use App\Enums\ReferenceContentTypeEnum;
use App\Enums\ReferenceStatusEnum;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    use Uuidable;

    protected $casts = [
        'content_type' => ReferenceContentTypeEnum::class,
        'status' => ReferenceStatusEnum::class,
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
