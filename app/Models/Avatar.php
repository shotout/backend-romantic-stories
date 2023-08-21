<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    // list status
    const IN_ACTIVE = 1;
    const ACTIVE = 2;

    public function image()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'avatar');
    }
}
