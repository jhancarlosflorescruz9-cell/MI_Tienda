<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function index()
    {
        return view('seguimiento.index');
    }

    public function buscar(string $codigo)
    {
        // Normalizar código
        $codigo = strtoupper(trim($codigo));
        if (!str_starts_with($codigo, '#')) {
            $codigo = '#' . $codigo;
        }

        $pedido = Pedido::where('codigo', $codigo)->first();

        if (!$pedido) {
            return view('seguimiento.index')->with('error', 'Pedido no encontrado. Verifica el código.');
        }

        $pasos = [
            ['key' => 'pendiente', 'label' => 'Pedido recibido',    'icono' => '📥', 'desc' => 'Tu pedido fue registrado correctamente.'],
            ['key' => 'proceso',   'label' => 'En proceso',          'icono' => '⚙️', 'desc' => 'Estamos preparando tu pedido ahora mismo.'],
            ['key' => 'listo',     'label' => 'Listo para recoger', 'icono' => '✅', 'desc' => '¡Ya puedes pasar a recogerlo!'],
            ['key' => 'entregado', 'label' => 'Entregado',           'icono' => '📦', 'desc' => 'Pedido completado. ¡Gracias por elegirnos!'],
        ];

        $orden  = ['pendiente' => 0, 'proceso' => 1, 'listo' => 2, 'entregado' => 3, 'cancelado' => -1];
        $indice = $orden[$pedido->estado] ?? 0;

        return view('seguimiento.resultado', compact('pedido', 'pasos', 'indice'));
    }
}
