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
        CREATE TABLE PERSONA (
    id_persona INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dpi VARCHAR(13) UNIQUE
);
        */
        Schema::create('persona', function (Blueprint $table) {
            $table->id('id_persona')->autoIncrement()->primary();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dpi', 13)->unique();
        });

        DB::table('persona')->insert([
            ['nombre' => 'Juan', 'apellido' => 'Pérez', 'dpi' => '1234567890123'],
            ['nombre' => 'María', 'apellido' => 'Gómez', 'dpi' => '9876543210987'],
            ['nombre' => 'Carlos', 'apellido' => 'López', 'dpi' => '4567891234567'],
            ['nombre' => 'Ana', 'apellido' => 'Martínez', 'dpi' => '3216549873210'],
            ['nombre' => 'Luis', 'apellido' => 'Hernández', 'dpi' => '6543217896543'],
            ['nombre' => 'Laura', 'apellido' => 'Ramírez', 'dpi' => '7891234567890'],
            ['nombre' => 'Javier', 'apellido' => 'Torres', 'dpi' => '1597534862587'],
            ['nombre' => 'Sofía', 'apellido' => 'Vásquez', 'dpi' => '7531598527410'],
            ['nombre' => 'Diego', 'apellido' => 'Morales', 'dpi' => '2589631478523'],
            ['nombre' => 'Valeria', 'apellido' => 'Cruz', 'dpi' => '3692581479630'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
