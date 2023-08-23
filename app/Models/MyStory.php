<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyStory extends Model
{
    use HasFactory;

    protected $table = 'my_story';

    protected $casts = [
        'stories' => 'json',
        'rules' => 'json'
    ];
}
