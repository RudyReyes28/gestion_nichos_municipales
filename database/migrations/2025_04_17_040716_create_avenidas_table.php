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
        CREATE TABLE AVENIDA (
    id_avenida INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_avenida VARCHAR(100) NOT NULL
);
        */
        Schema::create('avenida', function (Blueprint $table) {
            $table->id('id_avenida')->autoIncrement()->primary();
            $table->string('nombre_avenida', 100)->unique();
        });

        DB::table('avenida')->insert([
            ['nombre_avenida' => 'Avenida 1'],
            ['nombre_avenida' => 'Avenida 2'],
            ['nombre_avenida' => 'Avenida 3'],
            ['nombre_avenida' => 'Avenida 4'],
            ['nombre_avenida' => 'Avenida 5'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avenida');
    }
};
