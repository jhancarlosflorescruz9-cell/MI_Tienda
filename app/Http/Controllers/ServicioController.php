<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    // Lista todos los servicios
    public function index()
    {
        $servicios = Servicio::orderBy('orden')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    // Formulario crear
    public function create()
    {
        return view('admin.servicios.form', ['servicio' => new Servicio()]);
    }

    // Guardar nuevo servicio
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'icono'        => 'required|string|max:10',
            'precio_base'  => 'required|numeric|min:0',
            'precio_texto' => 'required|string|max:60',
            'orden'        => 'integer|min:0',
            'activo'       => 'boolean',
        ]);

        $data['activo'] = $request->has('activo');
        $data['orden']  = $request->input('orden', Servicio::max('orden') + 1);

        Servicio::create($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    // Formulario editar
    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.form', compact('servicio'));
    }

    // Actualizar servicio
    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:100',
            'icono'        => 'required|string|max:10',
            'precio_base'  => 'required|numeric|min:0',
            'precio_texto' => 'required|string|max:60',
            'orden'        => 'integer|min:0',
        ]);

        $data['activo'] = $request->has('activo');

        $servicio->update($data);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    // Eliminar servicio
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio eliminado.');
    }

    // Activar / desactivar rápido (AJAX)
    public function toggle(Servicio $servicio)
    {
        $servicio->update(['activo' => !$servicio->activo]);
        return response()->json(['activo' => $servicio->activo]);
    }
}
