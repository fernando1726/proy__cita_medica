<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('restrict');
            $table->foreignId('paciente_id')->constrained('users')->onDelete('restrict');
            $table->text('indicaciones');
            $table->json('medicamentos')->nullable();
            $table->timestamps();

            $table->index(['paciente_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};