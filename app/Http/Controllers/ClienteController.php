<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $servicios = [
            ['nombre' => 'Copias BN',                    'icono' => '🖤', 'precio' => 'Desde S/. 0.20 c/u', 'precio_base' => 0.20],
            ['nombre' => 'Copias a color',                'icono' => '🌈', 'precio' => 'Desde S/. 0.80 c/u', 'precio_base' => 0.80],
            ['nombre' => 'Impresion de documento',        'icono' => '📄', 'precio' => 'Desde S/. 0.30 c/u', 'precio_base' => 0.30],
            ['nombre' => 'Tipeo',                         'icono' => '⌨️', 'precio' => 'Desde S/. 5.00',     'precio_base' => 5.00],
            ['nombre' => 'Trabajo escolar/universitario', 'icono' => '🎓', 'precio' => 'Desde S/. 10.00',    'precio_base' => 10.00],
            ['nombre' => 'Impresion especial',            'icono' => '✨', 'precio' => 'Desde S/. 2.00 c/u', 'precio_base' => 2.00],
        ];

        $hora    = now()->hour;
        $abierto = ($hora >= 8 && $hora < 20);

        return view('cliente.index', compact('servicios', 'abierto'));
    }

    public function success(string $codigo)
    {
        // Buscar con o sin #
        $pedido = Pedido::where('codigo', $codigo)
            ->orWhere('codigo', '#'.$codigo)
            ->firstOrFail();
        return view('cliente.success', compact('pedido'));
    }
}