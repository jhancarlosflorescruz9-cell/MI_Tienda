<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('icono', 10)->default('📄');
            $table->decimal('precio_base', 8, 2);
            $table->string('precio_texto', 60);
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        // Insertar servicios por defecto
        DB::table('servicios')->insert([
            ['nombre' => 'Copias B&N',                   'icono' => '🖤', 'precio_base' => 0.20, 'precio_texto' => 'Desde S/. 0.20 c/u', 'activo' => true, 'orden' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Copias a color',                'icono' => '🌈', 'precio_base' => 0.80, 'precio_texto' => 'Desde S/. 0.80 c/u', 'activo' => true, 'orden' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Impresión de documento',        'icono' => '📄', 'precio_base' => 0.30, 'precio_texto' => 'Desde S/. 0.30 c/u', 'activo' => true, 'orden' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tipeo',                         'icono' => '⌨️', 'precio_base' => 5.00, 'precio_texto' => 'Desde S/. 5.00',     'activo' => true, 'orden' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Trabajo escolar/universitario', 'icono' => '🎓', 'precio_base' => 10.00,'precio_texto' => 'Desde S/. 10.00',    'activo' => true, 'orden' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Impresión especial',            'icono' => '✨', 'precio_base' => 2.00, 'precio_texto' => 'Desde S/. 2.00 c/u', 'activo' => true, 'orden' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('servicios');
    }
};
