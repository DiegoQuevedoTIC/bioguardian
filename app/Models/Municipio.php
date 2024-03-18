<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }
 
    public function veredas(): HasMany
    {
        return $this->hasMany(Vereda::class);
    }

    public function predialacuerdo(): HasMany
    {
        return $this->hasMany(PredialAcuerdo::class);
    }
}
