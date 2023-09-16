<?php

namespace App\Models;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningRun extends Model
{
    use HasFactory;
    use Uuidable;

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }
}
