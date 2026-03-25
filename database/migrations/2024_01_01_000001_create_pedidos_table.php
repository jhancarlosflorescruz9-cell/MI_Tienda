<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();           // #784521
            $table->string('servicio');                        // Copias B&N, etc.
            $table->integer('cantidad');                       // nro de hojas
            $table->string('tamano', 10)->default('A4');       // A4, A3, Carta, Oficio
            $table->string('entrega');                         // USB, WhatsApp, etc.
            $table->string('nombre');                          // nombre del cliente
            $table->string('telefono', 20);                    // whatsapp cliente
            $table->text('notas')->nullable();                 // indicaciones extra
            $table->boolean('anillado')->default(false);
            $table->boolean('tapa')->default(false);
            $table->boolean('doble_cara')->default(false);
            $table->decimal('total', 8, 2)->default(0);        // precio estimado
            $table->string('archivo_path')->nullable();        // ruta del archivo subido
            $table->string('archivo_nombre')->nullable();      // nombre original del archivo
            $table->string('metodo_pago')->nullable();         // yape, plin, null
            $table->string('voucher_path')->nullable();        // ruta del voucher
            $table->boolean('pago_verificado')->default(false);
            $table->enum('estado', [
                'pendiente',
                'proceso',
                'listo',
                'entregado',
                'cancelado'
            ])->default('pendiente');
            $table->timestamp('entregado_at')->nullable();
            $table->timestamps();                              // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
