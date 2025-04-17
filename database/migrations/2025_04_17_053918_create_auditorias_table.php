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
        CREATE TABLE AUDITORIA (
    id_auditoria INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    tipo_problema VARCHAR(100) NOT NULL,
    id_auditor INT NOT NULL,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    detalles_auditoria TEXT,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato),
    FOREIGN KEY (id_auditor) REFERENCES autenticacion(id_autenticacion)
);
        */
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id('id_auditoria')->autoIncrement()->primary();
            $table->foreignId('id_contrato')->constrained('contrato_nicho', 'id_contrato');
            $table->string('tipo_problema', 100);
            $table->foreignId('id_auditor')->constrained('autenticacion', 'id_autenticacion');
            $table->timestamp('fecha_hora')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('detalles_auditoria')->nullable();
            $table->string('estado', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
