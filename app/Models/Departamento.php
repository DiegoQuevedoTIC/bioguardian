<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class);
    }
 
    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }

    public function predialacuerdo(): HasMany
    {
        return $this->hasMany(PredialAcuerdo::class);
    }

}
