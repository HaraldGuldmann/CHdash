<?php

namespace App\Models;

use App\Enums\ClaimStatusEnum;
use App\Enums\MatchPolicyEnum;
use App\Rules\YouTubeUrlRule;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    use Uuidable;

    protected $casts = [
        'policy' => MatchPolicyEnum::class,
        'status' => ClaimStatusEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getVideoIdAttribute()
    {
        preg_match(YouTubeUrlRule::pattern, $this->video_url, $match);

        return $match[1];
    }
}
