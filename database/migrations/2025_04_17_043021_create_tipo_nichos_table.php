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
        /* CREATE TABLE TIPO_NICHO (
    id_tipo_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo VARCHAR(50) NOT NULL
);
*/

        Schema::create('tipo_nicho', function (Blueprint $table) {
            $table->id('id_tipo_nicho')->autoIncrement()->primary();
            $table->string('nombre_tipo', 50)->unique();
        });
        DB::table('tipo_nicho')->insert([
            ['nombre_tipo' => 'Adulto'],
            ['nombre_tipo' => 'Niño'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_nicho');
    }
};
