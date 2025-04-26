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
        
        Schema::create('registro_exhumaciones', function (Blueprint $table) {
            $table->id('id_exhumacion')->autoIncrement()->primary();
            $table->foreignId('id_contrato')->constrained('contrato_nicho', 'id_contrato')->onDelete('cascade');
            $table->string('persona_solicitante', 100);
            $table->foreignId('id_persona_solicitante')->references('id_persona')->on('persona')->onDelete('cascade');
            $table->text('motivo');
            $table->date('fecha_exhumacion');
            $table->string('estado', 20);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_exhumaciones');
    }
};
