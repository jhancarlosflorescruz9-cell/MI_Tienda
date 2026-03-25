<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            ['nombre' => 'Copias B&N',                   'precio' => 0.20],
            ['nombre' => 'Copias a color',                'precio' => 0.80],
            ['nombre' => 'Impresión de documento',        'precio' => 0.30],
            ['nombre' => 'Tipeo',                         'precio' => 5.00],
            ['nombre' => 'Trabajo escolar/universitario', 'precio' => 10.00],
        ];

        $nombres = ['Juan Pérez', 'María García', 'Carlos López', 'Ana Torres', 'Luis Flores', 'Rosa Mendoza', 'Pedro Castillo', 'Elena Ríos'];
        $estados = ['pendiente', 'pendiente', 'proceso', 'listo', 'entregado'];
        $tamaños = ['A4', 'A4', 'A4', 'A3', 'Carta'];

        for ($i = 0; $i < 20; $i++) {
            $svc      = $servicios[array_rand($servicios)];
            $cantidad = rand(1, 30);
            $anillado = rand(0, 1) > 0.7;
            $tapa     = rand(0, 1) > 0.7;
            $doble    = rand(0, 1) > 0.5;

            $total = Pedido::calcularTotal($svc['nombre'], $cantidad, $anillado, $tapa, $doble);

            Pedido::create([
                'codigo'     => Pedido::generarCodigo(),
                'servicio'   => $svc['nombre'],
                'cantidad'   => $cantidad,
                'tamano'     => $tamaños[array_rand($tamaños)],
                'entrega'    => 'Lo traigo en USB',
                'nombre'     => $nombres[array_rand($nombres)],
                'telefono'   => '9' . rand(10000000, 99999999),
                'notas'      => rand(0, 1) ? 'Con portada a color' : null,
                'anillado'   => $anillado,
                'tapa'       => $tapa,
                'doble_cara' => $doble,
                'total'      => $total,
                'estado'     => $estados[array_rand($estados)],
                'created_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 12)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ 20 pedidos de prueba creados.');
    }
}
