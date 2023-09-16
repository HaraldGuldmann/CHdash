<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    use Uuidable;

    public function earningRun()
    {
        return $this->belongsTo(EarningRun::class);
    }
}
