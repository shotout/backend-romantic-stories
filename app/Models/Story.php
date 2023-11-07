<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('\App\Models\Category')->with('cover');
    }

    public function is_collection()
    {
        return $this->hasOne('\App\Models\CollectionStory')->where('user_id', auth('sanctum')->user()->id);
    }

    public function audio()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'audio');
    }

    public function audio_enable()
    {
        return $this->hasOne('\App\Models\UserAudio')->where('user_id', auth('sanctum')->user()->id);
    }
}
