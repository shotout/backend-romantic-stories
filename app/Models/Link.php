<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    // type list
    const EXTERNAL_URL = 1;
    const INTERNAL_URL = 2;
        
    // flag list
    const LANDING = 'landing';
    const SOCIAL = 'social';
    
    public function icon()
    {
        return $this->hasOne('\App\Models\Media', 'owner_id')->where('type', 'link');
    }
}
