<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('numero_colegiatura', 50)->unique();
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('restrict');
            $table->decimal('tarifa_consulta', 10, 2)->default(0);
            $table->decimal('tarifa_adelanto', 10, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index(['especialidad_id', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};