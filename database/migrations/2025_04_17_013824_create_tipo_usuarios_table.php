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
        /*CREATE TABLE TIPO_USUARIO (
    id_tipo_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_usuario VARCHAR(50) NOT NULL
); */


        Schema::create('tipo_usuario', function (Blueprint $table) {
            $table->id('id_tipo_usuario')->autoIncrement()->primary();
            $table->string('tipo_usuario', 50)->unique();
        });

        DB::table('tipo_usuario')->insert([
            ['tipo_usuario' => 'Administrador'],
            ['tipo_usuario' => 'Ayudante'],
            ['tipo_usuario' => 'Auditor'],
            ['tipo_usuario' => 'Usuario'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_usuario');
    }
};
