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
        /* id_calle INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_calle VARCHAR(100) NOT NULL*/
        Schema::create('calle', function (Blueprint $table) {
            $table->id('id_calle')->autoIncrement()->primary();
            $table->string('nombre_calle', 100);
        });

        DB::table('calle')->insert([
            ['nombre_calle' => 'Calle 1'],
            ['nombre_calle' => 'Calle 2'],
            ['nombre_calle' => 'Calle 3'],
            ['nombre_calle' => 'Calle 4'],
            ['nombre_calle' => 'Calle 5'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calle');
    }
};
