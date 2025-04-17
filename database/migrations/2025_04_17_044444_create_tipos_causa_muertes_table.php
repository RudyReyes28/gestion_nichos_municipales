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
        CREATE TABLE TIPOS_CAUSA_MUERTE (
    id_tipo_muerte INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_causa VARCHAR(100) NOT NULL
);
        */
        Schema::create('tipos_causa_muerte', function (Blueprint $table) {
            $table->id('id_tipo_muerte')->autoIncrement()->primary();
            $table->string('nombre_causa', 100);

        });
        DB::table('tipos_causa_muerte')->insert([
            ['nombre_causa' => 'Enfermedad'],
            ['nombre_causa' => 'Accidente'],
            ['nombre_causa' => 'Suicidio'],
            ['nombre_causa' => 'Homicidio'],
            ['nombre_causa' => 'Desconocida'],
            ['nombre_causa' => 'Otros'],
            ['nombre_causa' => 'Natural'],
            ['nombre_causa' => 'Violencia'],
            ['nombre_causa' => 'Infección'],
            ['nombre_causa' => 'Envenenamiento'],
            ['nombre_causa' => 'Asfixia'],
            ['nombre_causa' => 'Drogadicción'],
            ['nombre_causa' => 'Alcoholismo'],
            ['nombre_causa' => 'Desnutrición'],
            ['nombre_causa' => 'Accidente de tráfico'],
            ['nombre_causa' => 'Accidente laboral'],
            ['nombre_causa' => 'Accidente doméstico'],
            ['nombre_causa' => 'Accidente deportivo'],
            ['nombre_causa' => 'Accidente aéreo'],
            ['nombre_causa' => 'Accidente marítimo'],
            ['nombre_causa' => 'Accidente ferroviario'],
            ['nombre_causa' => 'Accidente de montaña'],
            ['nombre_causa' => 'Accidente de tráfico en bicicleta'],
            ['nombre_causa' => 'Accidente de tráfico en motocicleta'],
            ['nombre_causa' => 'Accidente de tráfico en coche'],
            ['nombre_causa' => 'Accidente de tráfico en autobús'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_causa_muerte');
    }
};
