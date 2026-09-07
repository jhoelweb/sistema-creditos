<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Pago;

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

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
