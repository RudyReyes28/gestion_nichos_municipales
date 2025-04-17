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
        CREATE TABLE UBICACION_NICHO (
    id_ubicacion_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_calle INT,
    id_avenida INT,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_calle) REFERENCES CALLE(id_calle),
    FOREIGN KEY (id_avenida) REFERENCES AVENIDA(id_avenida)
);

        */
        Schema::create('ubicacion_nicho', function (Blueprint $table) {
            $table->id('id_ubicacion_nicho')->autoIncrement()->primary();
            $table->foreignId('id_calle')->constrained('calle', 'id_calle')->onDelete('cascade');
            $table->foreignId('id_avenida')->constrained('avenida', 'id_avenida')->onDelete('cascade');
            $table->string('descripcion', 255);
        });

        DB::table('ubicacion_nicho')->insert([
            ['id_calle' => 1, 'id_avenida' => 1, 'descripcion' => 'Calle Principal'],
            ['id_calle' => 2, 'id_avenida' => 2, 'descripcion' => 'Calle Secundaria'],
            ['id_calle' => 3, 'id_avenida' => 3, 'descripcion' => 'Calle Terciaria'],
            ['id_calle' => 4, 'id_avenida' => 4, 'descripcion' => 'Calle Cuaternaria'],
            ['id_calle' => 5, 'id_avenida' => 5, 'descripcion' => 'Calle Quintaria'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion_nicho');
    }
};
