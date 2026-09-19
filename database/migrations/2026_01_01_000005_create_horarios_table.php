<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('ocupado')->default(false);
            $table->boolean('es_festivo')->default(false);
            $table->timestamps();

            $table->index(['medico_id', 'fecha', 'ocupado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};