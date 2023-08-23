<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionStory extends Model
{
    use HasFactory;

    public function story()
    {
        return $this->belongsTo('\App\Models\Story');
    }
}
