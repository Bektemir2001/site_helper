<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $guarded = false;
    public function headers(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => json_decode($value)
        );
    }
}
