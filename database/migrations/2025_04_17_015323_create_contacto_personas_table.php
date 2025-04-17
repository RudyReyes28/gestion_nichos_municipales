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
        CREATE TABLE CONTACTO_PERSONA (
    id_contacto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100) UNIQUE,
    id_direccion INT,
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_direccion) REFERENCES DIRECCION(id_direccion)
); */
        Schema::create('contacto_persona', function (Blueprint $table) {
            $table->id('id_contacto')->autoIncrement()->primary();
            $table->foreignId('id_persona')->constrained('persona', 'id_persona')->onDelete('cascade');
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 100)->unique()->nullable();
            $table->foreignId('id_direccion')->constrained('direccion', 'id_direccion')->onDelete('cascade');
        });

        DB::table('contacto_persona')->insert([
        [
            'id_persona' => 1,
            'telefono' => '12345678',
            'correo' => 'juan@gmail.com',
            'id_direccion' => 1,
        ],
        [
            'id_persona' => 2,
            'telefono' => '87654321',
            'correo' => 'maria@gmail.com',
            'id_direccion' => 2,
        ],
        [
            'id_persona' => 3,
            'telefono' => '45678901',
            'correo' => 'carlos@gmail.com',
            'id_direccion' => 3,
        ],
        [
            'id_persona' => 4,
            'telefono' => '45678902',
            'correo' => 'ana@gmail.com',
            'id_direccion' => 4,
        ],
        [
            'id_persona' => 5,
            'telefono' => '45678903',
            'correo' => 'luis@gmail.com',
            'id_direccion' => 3,
        ],
        [
            'id_persona' => 6,
            'telefono' => '45678904',
            'correo' => 'laura@gmail.com',
            'id_direccion' => 4,
        ],
        [
            'id_persona' => 7,
            'telefono' => '45678905',
            'correo' => 'javier@gmail.com',
            'id_direccion' => 1,
        ],
        [
            'id_persona' => 8,
            'telefono' => '45678906',
            'correo' => 'sofia@gmail.com',
            'id_direccion' => 2,
        ],
        [
            'id_persona' => 9,
            'telefono' => '45678907',
            'correo' => 'diego@gmail.com',
            'id_direccion' => 3,
        ],
        [
            'id_persona' => 10,
            'telefono' => '45678908',
            'correo' => 'valeria@gmail.com',
            'id_direccion' => 4,
        ],]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacto_persona');
    }
};
