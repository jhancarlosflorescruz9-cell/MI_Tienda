<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre', 'icono', 'precio_base',
        'precio_texto', 'activo', 'orden',
    ];

    protected $casts = [
        'activo'      => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    // Solo servicios activos, ordenados
    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }
}
