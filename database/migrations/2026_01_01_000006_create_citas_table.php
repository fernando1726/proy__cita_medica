<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('restrict');
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('restrict');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado', [
                'pendiente_pago',
                'confirmada',
                'reprogramada',
                'cancelada',
                'atendida',
                'ausente',
            ])->default('pendiente_pago');
            $table->text('motivo_consulta')->nullable();
            $table->timestamps();

            $table->index(['paciente_id', 'estado']);
            $table->index(['medico_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};