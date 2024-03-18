<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('capacitacions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 3)->unique();
            $table->string('nombre');
            $table->decimal('no_talleres', 3)->nullable();
            $table->decimal('capacitaciones', 3)->nullable();
            $table->date("fecha")->nullable();
            $table->unsignedInteger('total_asistentes')->nullable();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('linea_id')->constrained('lineas')->cascadeOnDelete();
            $table->string('soporte_capacitacion'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitacions');
    }
};
