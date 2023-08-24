<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function icon()
    {
        return $this->belongsTo('\App\Models\Icon')->with('image');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category')->with('image');
    }

    public function get_avatar_male()
    {
        return $this->belongsTo('\App\Models\Avatar', 'avatar_male', 'id')->with('image');
    }

    public function get_avatar_female()
    {
        return $this->belongsTo('\App\Models\Avatar', 'avatar_female', 'id')->with('image');
    }

    public function theme()
    {
        return $this->hasOne('\App\Models\UserTheme');
    }

    public function language()
    {
        return $this->belongsTo('\App\Models\Language');
    }

    public function schedule()
    {
        return $this->hasOne('\App\Models\Schedule');
    }

    public function subscription()
    {
        return $this->hasOne('\App\Models\Subscription')->where('status', 2)->with('plan');
    }

    public function my_story()
    {
        return $this->hasOne('\App\Models\MyStory');
    }
}
