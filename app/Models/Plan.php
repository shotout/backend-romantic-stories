<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $cast = [
    //     'notes' => 'json',
    //     'price' => PriceCast::class,
    // ];

    protected function notes(): Attribute
    {
        return new Attribute(
            get: fn () => json_decode($this->attributes['notes'])
        );
    }

    // protected function price(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => $this->attributes['price'] / 100
    //     );
    // }
}
