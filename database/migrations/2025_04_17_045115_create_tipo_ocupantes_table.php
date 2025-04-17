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
        CREATE TABLE TIPO_OCUPANTE (
    id_tipo_ocupante INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL
);
 */
        Schema::create('tipo_ocupante', function (Blueprint $table) {
            $table->id('id_tipo_ocupante')->autoIncrement()->primary();
            $table->string('tipo', 50)->nullable(false);
        });

        DB::table('tipo_ocupante')->insert([
            ['tipo' => 'Usuario Normal'],
            ['tipo' => 'Personaje Historico'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_ocupante');
    }
};
