<?php

namespace App\Models;

use App\Enums\AssetStatusEnum;
use App\Enums\AssetTypeEnum;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, Uuidable;

    protected $casts = [
        'status' => AssetStatusEnum::class.'nullable',
        'type' => AssetTypeEnum::class,
        'alias_ids' => 'array',
        'metadata' => 'array',
        'ownership' => 'array',
        'ownership_conflicts' => 'array',
    ];

    public function contentOwner()
    {
        return $this->belongsTo(ContentOwner::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
