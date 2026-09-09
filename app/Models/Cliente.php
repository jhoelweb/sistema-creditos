<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'documento_identidad',
        'telefono',
        'correo',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Usuario asociado al cliente.
     */
    public function usuario(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Créditos pertenecientes al cliente.
     */
    public function creditos(): HasMany
    {
        return $this->hasMany(Credito::class);
    }
}