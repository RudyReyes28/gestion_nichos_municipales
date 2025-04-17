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
        CREATE TABLE DIRECCION (
    id_direccion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_municipio INT NOT NULL,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_municipio) REFERENCES MUNICIPIO(id_municipio)
);
        */
        Schema::create('direccion', function (Blueprint $table) {
            $table->id('id_direccion')->autoIncrement()->primary();
            $table->foreignId('id_municipio')->constrained('municipio', 'id_municipio')->onDelete('cascade');
            $table->string('descripcion', 255)->nullable();
        });

        DB::table('direccion')->insert([
            'id_municipio' => 96,
            'descripcion' => 'Zona 1',
        ]);
        DB::table('direccion')->insert([
            'id_municipio' => 97,
            'descripcion' => 'Zona 2',
        ]);
        DB::table('direccion')->insert([
            'id_municipio' => 98,
            'descripcion' => 'Zona 3',
        ]);
        DB::table('direccion')->insert([
            'id_municipio' => 99,
            'descripcion' => 'Zona 4',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccion');
    }
};
