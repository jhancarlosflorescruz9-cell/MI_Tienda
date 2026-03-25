<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'codigo', 'servicio', 'cantidad', 'tamano', 'entrega',
        'nombre', 'telefono', 'notas',
        'anillado', 'tapa', 'doble_cara', 'total',
        'archivo_path', 'archivo_nombre',
        'metodo_pago', 'voucher_path', 'pago_verificado',
        'estado', 'entregado_at',
    ];

    protected $casts = [
        'anillado'        => 'boolean',
        'tapa'            => 'boolean',
        'doble_cara'      => 'boolean',
        'pago_verificado' => 'boolean',
        'total'           => 'decimal:2',
        'entregado_at'    => 'datetime',
    ];

    /* ── ESTADO: etiqueta ── */
    public function estadoLabel()
    {
        switch ($this->estado) {
            case 'pendiente': return '🟡 Pendiente';
            case 'proceso':   return '🔵 En proceso';
            case 'listo':     return '🟢 Listo';
            case 'entregado': return '⚪ Entregado';
            case 'cancelado': return '🔴 Cancelado';
            default:          return $this->estado;
        }
    }

    /* ── ESTADO: color texto ── */
    public function estadoColor()
    {
        switch ($this->estado) {
            case 'pendiente': return '#854d0e';
            case 'proceso':   return '#003fa3';
            case 'listo':     return '#16a34a';
            case 'entregado': return '#374151';
            case 'cancelado': return '#e8001c';
            default:          return '#374151';
        }
    }

    /* ── ESTADO: color fondo ── */
    public function estadoBg()
    {
        switch ($this->estado) {
            case 'pendiente': return '#fef9c3';
            case 'proceso':   return '#dbeafe';
            case 'listo':     return '#dcfce7';
            case 'entregado': return '#f3f4f6';
            case 'cancelado': return '#fee2e2';
            default:          return '#f3f4f6';
        }
    }

    /* ── EXTRAS como texto ── */
    public function extrasTexto()
    {
        $extras = [];
        if ($this->anillado)   $extras[] = 'Anillado (+S/.3.00)';
        if ($this->tapa)       $extras[] = 'Tapa plástica (+S/.1.50)';
        if ($this->doble_cara) $extras[] = 'Doble cara';
        return empty($extras) ? 'Ninguno' : implode(', ', $extras);
    }

    /* ── SCOPES ── */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeBuscar($query, $q)
    {
        return $query->where(function ($sub) use ($q) {
            $sub->where('nombre',   'like', "%{$q}%")
                ->orWhere('codigo',   'like', "%{$q}%")
                ->orWhere('telefono', 'like', "%{$q}%")
                ->orWhere('servicio', 'like', "%{$q}%");
        });
    }

    /* ── CÓDIGO ÚNICO ── */
    public static function generarCodigo()
    {
        do {
            $codigo = '#' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('codigo', $codigo)->exists());

        return $codigo;
    }

    /* ── CALCULAR TOTAL ── */
    public static function calcularTotal($servicio, $cantidad, $anillado, $tapa, $doble)
    {
        $precios = [
            'Copias B&N'                      => 0.20,
            'Copias a color'                   => 0.80,
            'Impresión de documento'           => 0.30,
            'Tipeo'                            => 5.00,
            'Trabajo escolar/universitario'    => 10.00,
            'Impresión especial'               => 2.00,
        ];

        $precio = isset($precios[$servicio]) ? $precios[$servicio] : 0.30;
        $total  = $precio * $cantidad;
        if ($anillado) $total += 3.00;
        if ($tapa)     $total += 1.50;
        if ($doble)    $total += 0.10 * $cantidad;

        return round($total, 2);
    }
}