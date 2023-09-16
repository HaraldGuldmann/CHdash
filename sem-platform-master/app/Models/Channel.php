<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    use Uuidable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'statistics' => 'array',
        'linked_at' => 'datetime'
    ];

    /**
     * Channel Belongs To Content Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contentOwner()
    {
        return $this->belongsTo(ContentOwner::class);
    }
}
