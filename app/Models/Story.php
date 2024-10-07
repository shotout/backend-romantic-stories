<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    
    protected function contentEn(): Attribute
    {
        return new Attribute(
            get: fn () => str_replace("\r\n", " ", $this->attributes['content_en'])
        );
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category')
            ->with('cover:id,owner_id,name,url','cover_audio:id,owner_id,name,url');
    }

    public function is_rating()
    {
        return $this->hasOne('\App\Models\StoryRating')->where('user_id', auth('sanctum')->user()->id);
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
