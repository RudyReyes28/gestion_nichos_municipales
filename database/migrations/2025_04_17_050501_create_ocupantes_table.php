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
        CREATE TABLE OCUPANTE (
    id_ocupante INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    fecha_fallecimiento DATE,
    id_tipo_muerte INT,
    id_tipo_ocupante INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_tipo_muerte) REFERENCES TIPOS_CAUSA_MUERTE(id_tipo_muerte),
    FOREIGN KEY (id_tipo_ocupante) REFERENCES TIPO_OCUPANTE(id_tipo_ocupante)
);*/
        Schema::create('ocupante', function (Blueprint $table) {
            $table->id('id_ocupante')->autoIncrement()->primary();
            $table->foreignId('id_persona')->constrained('persona', 'id_persona')->onDelete('cascade');
            $table->date('fecha_fallecimiento')->nullable();
            $table->foreignId('id_tipo_muerte')->nullable()->constrained('tipos_causa_muerte', 'id_tipo_muerte')->onDelete('cascade');
            $table->foreignId('id_tipo_ocupante')->constrained('tipo_ocupante', 'id_tipo_ocupante')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocupante');
    }
};
