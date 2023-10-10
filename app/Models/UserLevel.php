<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;
    protected $table = "user_level";

    public function level()
    {
        return $this->belongsTo('\App\Models\Level')->with('image');
    }
}
