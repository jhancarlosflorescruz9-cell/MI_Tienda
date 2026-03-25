<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    /* ══════════════════════════════
       LOGIN
    ══════════════════════════════ */

    public function loginForm()
    {
        if (Session::get('admin_auth')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'usuario'    => 'required|string',
            'password'   => 'required|string',
        ]);

        $usuario  = config('admin.usuario', 'admin');
        $password = config('admin.password', 'admin123');

        if ($request->usuario === $usuario && $request->password === $password) {
            Session::put('admin_auth', true);
            Session::put('admin_expiry', now()->addHours(8)->timestamp);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['credenciales' => 'Usuario o contraseña incorrectos.']);
    }

    public function logout()
    {
        Session::forget(['admin_auth', 'admin_expiry']);
        return redirect()->route('admin.login');
    }

    /* ══════════════════════════════
       DASHBOARD
    ══════════════════════════════ */

    public function dashboard()
    {
        $stats = [
            'total'      => Pedido::count(),
            'pendientes' => Pedido::where('estado', 'pendiente')->count(),
            'proceso'    => Pedido::where('estado', 'proceso')->count(),
            'listos'     => Pedido::where('estado', 'listo')->count(),
            'entregados' => Pedido::where('estado', 'entregado')->count(),
            'cancelados' => Pedido::where('estado', 'cancelado')->count(),
            'ingresos'   => Pedido::sum('total'),
            'hoy'        => Pedido::whereDate('created_at', today())->count(),
            'ingresos_hoy' => Pedido::whereDate('created_at', today())->sum('total'),
            'ingresos_mes' => Pedido::whereMonth('created_at', now()->month)->sum('total'),
        ];

        // Top servicios
        $porServicio = Pedido::selectRaw('servicio, count(*) as total')
            ->groupBy('servicio')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // Pedidos últimos 7 días
        $porDia = Pedido::selectRaw('DATE(created_at) as dia, count(*) as pedidos, sum(total) as ingresos')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // Últimos 5 pedidos
        $recientes = Pedido::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'porServicio', 'porDia', 'recientes'));
    }

    /* ══════════════════════════════
       LISTA DE PEDIDOS
    ══════════════════════════════ */

    public function pedidos(Request $request)
    {
        $query = Pedido::latest();
    
        // Filtro por estado
        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }
    
        // Búsqueda
        if ($request->filled('q')) {
            $query->buscar($request->q);
        }
    
        // ── RESPUESTA JSON para verificar pedidos nuevos (AJAX) ──
        if ($request->expectsJson() || $request->filled('ultimo_id')) {
            $ultimoId   = (int) $request->input('ultimo_id', 0);
            $nuevos     = Pedido::where('id', '>', $ultimoId)->count();
            $ultimoReal = Pedido::latest()->value('id') ?? 0;
            return response()->json([
                'nuevos'    => $nuevos,
                'ultimo_id' => $ultimoReal,
                'total'     => Pedido::count(),
                'pendientes'=> Pedido::where('estado','pendiente')->count(),
            ]);
        }
    
        // ── RESPUESTA NORMAL HTML ──
        $pedidos = $query->paginate(20)->withQueryString();
    
        $conteos = [
            'todos'     => Pedido::count(),
            'pendiente' => Pedido::where('estado','pendiente')->count(),
            'proceso'   => Pedido::where('estado','proceso')->count(),
            'listo'     => Pedido::where('estado','listo')->count(),
            'entregado' => Pedido::where('estado','entregado')->count(),
            'cancelado' => Pedido::where('estado','cancelado')->count(),
        ];
    
        return view('admin.pedidos', compact('pedidos', 'conteos'));
    }

    /* ══════════════════════════════
       CAMBIAR ESTADO
    ══════════════════════════════ */

    public function cambiarEstado(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,proceso,listo,entregado,cancelado',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        if ($request->estado === 'entregado') {
            $pedido->entregado_at = now();
        }
        $pedido->save();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'estado' => $pedido->estado]);
        }

        return back()->with('success', "Pedido {$pedido->codigo} actualizado a: {$pedido->estado}");
    }

    /* ══════════════════════════════
       ELIMINAR PEDIDO
    ══════════════════════════════ */

    public function eliminar(int $id)
    {
        $pedido = Pedido::findOrFail($id);
        // Eliminar archivos si existen
        if ($pedido->archivo_path) {
            Storage::disk('public')->delete($pedido->archivo_path);
        }
        if ($pedido->voucher_path) {
            Storage::disk('public')->delete($pedido->voucher_path);
        }
        $pedido->delete();

        return back()->with('success', "Pedido eliminado correctamente.");
    }

    /* ══════════════════════════════
       EXPORTAR CSV
    ══════════════════════════════ */

    public function exportarCSV()
    {
        $pedidos = Pedido::orderByDesc('created_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="pedidos-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($pedidos) {
            $file = fopen('php://output', 'w');
            // BOM para Excel
            fputs($file, "\xEF\xBB\xBF");
            // Cabecera
            fputcsv($file, ['Código','Estado','Servicio','Nombre','Teléfono','Cantidad','Tamaño','Entrega','Anillado','Tapa','Doble cara','Total S/.','Notas','Fecha']);
            // Filas
            foreach ($pedidos as $p) {
                fputcsv($file, [
                    $p->codigo, $p->estado, $p->servicio,
                    $p->nombre, $p->telefono, $p->cantidad,
                    $p->tamano, $p->entrega,
                    $p->anillado   ? 'Sí' : 'No',
                    $p->tapa       ? 'Sí' : 'No',
                    $p->doble_cara ? 'Sí' : 'No',
                    number_format($p->total, 2),
                    $p->notas ?? '',
                    $p->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ══════════════════════════════
       ESTADÍSTICAS
    ══════════════════════════════ */

    public function estadisticas()
    {
        $porServicio = Pedido::selectRaw('servicio, count(*) as cantidad, sum(total) as ingresos')
            ->groupBy('servicio')->orderByDesc('cantidad')->get();

        $porDia = Pedido::selectRaw('DATE(created_at) as dia, count(*) as pedidos, sum(total) as ingresos')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('dia')->orderBy('dia')->get();

        $porEstado = Pedido::selectRaw('estado, count(*) as cantidad')
            ->groupBy('estado')->get();

        return view('admin.estadisticas', compact('porServicio', 'porDia', 'porEstado'));
    }
}
