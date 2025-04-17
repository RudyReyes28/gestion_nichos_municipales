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
        CREATE TABLE AUTENTICACION (
    id_autenticacion INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    id_tipo_usuario INT NOT NULL,
    usuario VARCHAR(100),
    contrasenia VARCHAR(255),
    estado VARCHAR(20),
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_tipo_usuario) REFERENCES TIPO_USUARIO(id_tipo_usuario)
);
        */
        Schema::create('autenticacion', function (Blueprint $table) {
            $table->id('id_autenticacion')->autoIncrement()->primary();
            $table->foreignId('id_persona')->constrained('persona', 'id_persona');
            $table->foreignId('id_tipo_usuario')->constrained('tipo_usuario', 'id_tipo_usuario');
            $table->string('usuario', 100);
            $table->string('contrasenia', 255);
            $table->string('estado', 20);
        });

        DB::table('autenticacion')->insert([
            'id_persona' => 1,
            'id_tipo_usuario' => 1,
            'usuario' => 'admin',
            'contrasenia' => bcrypt('admin'),
            'estado' => 'activo',
        ]);

        DB::table('autenticacion')->insert([
            'id_persona' => 2,
            'id_tipo_usuario' => 2,
            'usuario' => 'ayudante',
            'contrasenia' => bcrypt('ayudante'),
            'estado' => 'activo',
        ]);

        DB::table('autenticacion')->insert([
            'id_persona' => 3,
            'id_tipo_usuario' => 3,
            'usuario' => 'auditor',
            'contrasenia' => bcrypt('auditor'),
            'estado' => 'activo',
        ]);

        DB::table('autenticacion')->insert([
            'id_persona' => 4,
            'id_tipo_usuario' => 4,
            'usuario' => 'usuario',
            'contrasenia' => bcrypt('usuario'),
            'estado' => 'activo',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autenticacion');
    }
};
