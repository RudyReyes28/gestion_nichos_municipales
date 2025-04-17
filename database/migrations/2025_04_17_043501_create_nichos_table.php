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
        CREATE TABLE NICHOS (
    id_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipo_nicho INT,
    id_ubicacion_nicho INT,
    descripcion VARCHAR(255),
    estado VARCHAR(20),
    FOREIGN KEY (id_tipo_nicho) REFERENCES TIPO_NICHO(id_tipo_nicho),
    FOREIGN KEY (id_ubicacion_nicho) REFERENCES UBICACION_NICHO(id_ubicacion_nicho)
);*/
        Schema::create('nichos', function (Blueprint $table) {
            $table->id('id_nicho')->autoIncrement()->primary();
            $table->foreignId('id_tipo_nicho')->constrained('tipo_nicho', 'id_tipo_nicho')->onDelete('cascade');
            $table->foreignId('id_ubicacion_nicho')->constrained('ubicacion_nicho', 'id_ubicacion_nicho')->onDelete('cascade');
            $table->string('descripcion', 255);
            $table->string('estado', 20);
        });

        DB::table('nichos')->insert([
            [
                'id_tipo_nicho' => 1,
                'id_ubicacion_nicho' => 1,
                'descripcion' => 'Nicho 1',
                'estado' => 'disponible'
            ],
            [
                'id_tipo_nicho' => 2,
                'id_ubicacion_nicho' => 2,
                'descripcion' => 'Nicho 2',
                'estado' => 'disponible'
            ],
            [
                'id_tipo_nicho' => 1,
                'id_ubicacion_nicho' => 3,
                'descripcion' => 'Nicho 3',
                'estado' => 'disponible'
            ],
            [
                'id_tipo_nicho' => 2,
                'id_ubicacion_nicho' => 4,
                'descripcion' => 'Nicho 4',
                'estado' => 'disponible'
            ],
            [
                'id_tipo_nicho' => 1,
                'id_ubicacion_nicho' => 5,
                'descripcion' => 'Nicho 5',
                'estado' => 'disponible'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nichos');
    }
};
