<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        // ── VALIDACIÓN ──
        $validated = $request->validate([
            'servicio'   => 'required|string',
            'cantidad'   => 'nullable|integer|min:1|max:500',
            'tamano'     => 'nullable|string',
            'entrega'    => 'nullable|string',
            'nombre'     => 'required|string|min:3|max:100',
            'telefono'   => ['required', 'string', 'regex:/^9\d{8}$/'],
            'notas'      => 'nullable|string|max:500',
            'tapa'       => 'boolean',
            'doble_cara' => 'boolean',
        ], [
            'servicio.required'  => 'Selecciona un servicio.',
            'nombre.min'         => 'El nombre debe tener al menos 3 caracteres.',
            'telefono.regex'     => 'El número debe tener 9 dígitos y empezar con 9.',
        ]);

        // ── VALORES POR DEFECTO ──
        $validated['cantidad'] = $validated['cantidad'] ?? 1;
        $validated['tamano']   = $validated['tamano']   ?? 'A4';
        $validated['entrega']  = $validated['entrega']  ?? 'Lo traigo en USB';

        // ── VERIFICAR HORARIO ──
        $hora = now()->hour;
        if ($hora < 8 || $hora >= 20) {
            return back()
                ->withInput()
                ->withErrors(['horario' => 'Estamos fuera del horario de atención (8:00am - 8:00pm).']);
        }

        // ── CALCULAR TOTAL ──
        $anillado = $request->input('anillado') ? true : false;
        $tapa     = $request->input('tapa')     ? true : false;
        $doble    = $request->input('doble_cara') ? true : false;

        $total = Pedido::calcularTotal(
            $validated['servicio'],
            $validated['cantidad'],
            $anillado, $tapa, $doble
        );

        // ── CREAR PEDIDO ──
        $pedido = Pedido::create([
            'codigo'     => Pedido::generarCodigo(),
            'servicio'   => $validated['servicio'],
            'cantidad'   => $validated['cantidad'],
            'tamano'     => $validated['tamano'],
            'entrega'    => $validated['entrega'],
            'nombre'     => $validated['nombre'],
            'telefono'   => $validated['telefono'],
            'notas'      => $validated['notas'] ?? null,
            'anillado'   => $anillado,
            'tapa'       => $tapa,
            'doble_cara' => $doble,
            'total'      => $total,
            'estado'     => 'pendiente',
        ]);

        // ── ARCHIVO ADJUNTO ──
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $path = $file->store("pedidos/{$pedido->codigo}", 'public');
            $pedido->update([
                'archivo_path'   => $path,
                'archivo_nombre' => $file->getClientOriginalName(),
            ]);
        }

        // ── REDIRIGIR A ÉXITO ──
        $codigoUrl = ltrim($pedido->codigo, '#');
        return redirect()->route('pedidos.success', $codigoUrl);
    }

    public function success(string $codigo)
    {
        $pedido = Pedido::where('codigo', $codigo)->firstOrFail();
        return view('cliente.success', compact('pedido'));
    }

    public function subirArchivo(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,txt',
        ]);

        $file = $request->file('archivo');
        $path = $file->store('temp_archivos', 'public');

        return response()->json([
            'success' => true,
            'path'    => $path,
            'nombre'  => $file->getClientOriginalName(),
            'tamano'  => round($file->getSize() / 1024, 1) . ' KB',
            'tipo'    => $file->getClientMimeType(),
        ]);
    }
}