<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value / 100;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value * 100;
    }
}