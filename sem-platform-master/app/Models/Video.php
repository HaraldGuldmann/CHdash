<?php

namespace App\Models;

use App\Enums\ReferenceContentTypeEnum;
use App\Enums\VideoStatusEnum;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    use Uuidable;

    protected $casts = [
        'status' => VideoStatusEnum::class,
        'content_type' => ReferenceContentTypeEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
