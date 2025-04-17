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
        /*CREATE TABLE REGISTRO_EXHUMACIONES (
    id_exhumacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    persona_solicitante VARCHAR(100),
    motivo TEXT,
    fecha_exhumacion DATE,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato)
); */
        Schema::create('registro_exhumaciones', function (Blueprint $table) {
            $table->id('id_exhumacion')->autoIncrement()->primary();
            $table->foreignId('id_contrato')->constrained('contrato_nicho', 'id_contrato')->onDelete('cascade');
            $table->string('persona_solicitante', 100);
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
