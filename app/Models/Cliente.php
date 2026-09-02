<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}