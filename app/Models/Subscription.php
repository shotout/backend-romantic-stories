<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    // list type
    const FREE = 1;
    const MONTHLY = 2;
    const YEARLY = 3;
    const LIFETIME = 4;
    const ONE_MONTH_FREE = 5;
    
    // list status
    const IN_ACTIVE = 1;
    const ACTIVE = 2;

    public function plan()
    {
        return $this->belongsTo('\App\Models\Plan');
    }
}
