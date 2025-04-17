<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        /*
        CREATE TABLE DEPARTAMENTO (
            id_departamento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL
        );
        
        */
        Schema::create('departamento', function (Blueprint $table) {
            $table->id('id_departamento')->autoIncrement()->primary();
            $table->string('nombre', 100)->unique();
        });

        DB::table('departamento')->insert([
            ['nombre' => 'Alta Verapaz'],
            ['nombre' => 'Baja Verapaz'],
            ['nombre' => 'Chimaltenango'],
            ['nombre' => 'Chiquimula'],
            ['nombre' => 'El Progreso'],
            ['nombre' => 'Escuintla'],
            ['nombre' => 'Guatemala'],
            ['nombre' => 'Huehuetenango'],
            ['nombre' => 'Izabal'],
            ['nombre' => 'Jalapa'],
            ['nombre' => 'Jutiapa'],
            ['nombre' => 'Petén'],
            ['nombre' => 'Quetzaltenango'],
            ['nombre' => 'Quiché'],
            ['nombre' => 'Retalhuleu'],
            ['nombre' => 'Sacatepéquez'],
            ['nombre' => 'San Marcos'],
            ['nombre' => 'Santa Rosa'],
            ['nombre' => 'Sololá'],
            ['nombre' => 'Suchitepéquez'],
            ['nombre' => 'Totonicapán'],
            ['nombre' => 'Zacapa'],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamento');
    }
};
