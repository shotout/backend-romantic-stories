<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // list status
    const IN_ACTIVE = 1;
    const ACTIVE = 2;

    public function image()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'category');
    }

    public function cover()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'category_cover');
    }

    public function cover_audio()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'cover_audio');
    }
}
