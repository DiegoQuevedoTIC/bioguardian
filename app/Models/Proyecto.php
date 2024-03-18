<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    public function predialacuerdo(): HasMany
    {
        return $this->hasMany(PredialAcuerdo::class);
    }

    public function capaction(): HasMany
    {
        return $this->hasMany(Capacitacion::class);
    }
}
