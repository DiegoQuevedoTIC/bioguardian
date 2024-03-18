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
        Schema::create('predial_acuerdos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 16)->unique();
            $table->string('nombre');
            $table->foreignId('paisaje_id')->constrained('paisajes')->cascadeOnDelete();
            $table->foreignId('linea_id')->constrained('lineas')->cascadeOnDelete();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('departamento_id')->constrained('departamentos')->cascadeOnDelete();
            $table->foreignId('municipio_id')->constrained('municipios')->cascadeOnDelete();
            $table->foreignId('vereda_id')->constrained('veredas')->cascadeOnDelete();
            $table->string('id_predio',12)->nullable();
            $table->string('nombre_firmante_local')->nullable();
            $table->string('id_firmante_local',16)->nullable();
            $table->date("fecha_inicial")->nullable();
            $table->date("fecha_finalizacion")->nullable();
            $table->foreignId('estado_id')->constrained('estados')->cascadeOnDelete();
            $table->boolean('renovado')->default(false);
            $table->string('firmante_lider')->nullable();
            $table->string('firmantes_adicionales')->nullable();
            $table->decimal('area_predio', 10, 2)->nullable();
            $table->decimal('area_bosque', 10, 2)->nullable();
            $table->decimal('area_productiva', 10, 2)->nullable();
            $table->boolean('planificacion')->default(false);
            $table->boolean('area_protegida')->default(false);
            $table->string('areas_protegidas_id')->nullable();
            $table->string('especies_valores_conservacion')->nullable();
            $table->boolean('restauracion')->default(false);
            $table->boolean('sistemas_productivos')->default(false);
            $table->boolean('seguridad_alimentaria')->default(false);
            $table->boolean('wash')->default(false);
            $table->boolean('iniciativa_biodiversidad')->default(false);
            $table->string('especies_sostenibles')->nullable();
            $table->boolean('asesoria_tecnica')->default(false);
            $table->decimal('area_cadena_valor_sostenible', 10, 2)->nullable();
            $table->string('cadena_valor')->nullable();
            $table->float('inversion',13, 2)->nullable();
            $table->unsignedInteger('familias_beneficio')->nullable();
            $table->unsignedInteger('personas_beneficio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predial_acuerdos');
    }
};
