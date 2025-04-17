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
        /*
        CREATE TABLE BOLETA_PAGO (
    id_boleta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    total DECIMAL(10,2),
    estado VARCHAR(20),
    ruta_comprobante VARCHAR(255),
    fecha_emision DATE,
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato)
);
        */
        Schema::create('boleta_pago', function (Blueprint $table) {
            $table->id('id_boleta')->autoIncrement()->primary();
            $table->foreignId('id_contrato')->constrained('contrato_nicho', 'id_contrato')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->string('estado', 20);
            $table->string('ruta_comprobante', 255);
            $table->date('fecha_emision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boleta_pago');
    }
};
