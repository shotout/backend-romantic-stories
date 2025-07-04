<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'lang');
    }
}
