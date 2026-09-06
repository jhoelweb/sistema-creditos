<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credito extends Model
{
    protected $fillable = [
        'cliente_id',
        'fecha_otorgamiento',
        'monto',
        'tasa_interes',
        'plazo',
        'total_credito',
        'saldo',
        'fecha_vencimiento',
        'estado',
    ];

    protected $casts = [
        'fecha_otorgamiento' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
        'tasa_interes' => 'decimal:2',
        'total_credito' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
