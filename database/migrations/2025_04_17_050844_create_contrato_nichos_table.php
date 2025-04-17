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
        /* CREATE TABLE CONTRATO_NICHO (
    id_contrato INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario_generador INT NOT NULL,
    id_nicho INT NOT NULL,
    id_ocupante INT NOT NULL,
    id_responsable INT NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    fecha_gracia DATE,
    estado_contrato VARCHAR(20),
    estado_pago VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario_generador) REFERENCES AUTENTICACION(id_autenticacion),
    FOREIGN KEY (id_nicho) REFERENCES NICHOS(id_nicho),
    FOREIGN KEY (id_ocupante) REFERENCES OCUPANTE(id_ocupante),
    FOREIGN KEY (id_responsable) REFERENCES PERSONA(id_persona)
);*/
        Schema::create('contrato_nicho', function (Blueprint $table) {
            $table->id('id_contrato')->autoIncrement()->primary();
            $table->foreignId('id_usuario_generador')->constrained('autenticacion', 'id_autenticacion');
            $table->foreignId('id_nicho')->constrained('nichos', 'id_nicho');
            $table->foreignId('id_ocupante')->constrained('ocupante', 'id_ocupante');
            $table->foreignId('id_responsable')->constrained('persona', 'id_persona');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_gracia')->nullable();
            $table->string('estado_contrato', 20)->nullable();
            $table->string('estado_pago', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_nicho');
    }
};
