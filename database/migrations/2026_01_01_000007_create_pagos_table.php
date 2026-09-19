<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->enum('tipo', ['adelanto', 'consulta_completa']);
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->string('referencia_transaccion')->nullable()->unique();
            $table->string('pasarela', 50)->nullable();
            $table->timestamps();

            $table->index(['cita_id', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};