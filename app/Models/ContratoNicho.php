<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoNicho extends Model
{
    protected $table = 'contrato_nicho';
    //
    /*CREATE TABLE CONTRATO_NICHO (
    id_contrato INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario_generador INT NOT NULL,
    id_nicho INT NOT NULL,
    id_ocupante INT NOT NULL,
    id_responsable INT NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    fecha_gracia DATE,
    estado_contrato VARCHAR(20),
    estado_pago VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario_generador) REFERENCES AUTENTICACION(id_autenticacion),
    FOREIGN KEY (id_nicho) REFERENCES NICHOS(id_nicho),
    FOREIGN KEY (id_ocupante) REFERENCES OCUPANTE(id_ocupante),
    FOREIGN KEY (id_responsable) REFERENCES PERSONA(id_persona)
); */

    public static function solicitarContrato($id_nicho, $id_ocupante, $id_responsable)
    {
        $id_usuario_generador = 1;
        $estado_contrato = 'solicitado';
        $estado_pago = 'solicitado';

        return DB::insert('INSERT INTO contrato_nicho (id_usuario_generador, id_nicho, id_ocupante, id_responsable, estado_contrato, estado_pago) VALUES (?, ?, ?, ?, ?, ?)', [$id_usuario_generador, $id_nicho, $id_ocupante, $id_responsable, $estado_contrato, $estado_pago]);
    }

    public static function allContratoNicho()
    {
        return DB::select('SELECT * FROM contrato_nicho');
    }

    public static function getContratoNicho($id)
    {
        return DB::select('SELECT * FROM contrato_nicho WHERE id_contrato = ?', [$id]);
    }

    public static function createContratoNicho($id_usuario_generador, $id_nicho, $id_ocupante, $id_responsable, $fecha_inicio, $fecha_fin, $fecha_gracia, $estado_contrato, $estado_pago)
    {
        return DB::insert('INSERT INTO contrato_nicho (id_usuario_generador, id_nicho, id_ocupante, id_responsable, fecha_inicio, fecha_fin, fecha_gracia, estado_contrato, estado_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$id_usuario_generador, $id_nicho, $id_ocupante, $id_responsable, $fecha_inicio, $fecha_fin, $fecha_gracia, $estado_contrato, $estado_pago]);
    }

    public static function updateContratoNicho($id_contrato,$id_usuario_generador,$id_nicho,$id_ocupante,$id_responsable,$fecha_inicio,$fecha_fin,$fecha_gracia,$estado_contrato,$estado_pago)
    {
        return DB::update('UPDATE contrato_nicho SET id_usuario_generador = ?, id_nicho = ?, id_ocupante = ?, id_responsable = ?, fecha_inicio = ?, fecha_fin = ?, fecha_gracia = ?, estado_contrato = ?, estado_pago = ? WHERE id_contrato = ?', [$id_usuario_generador,$id_nicho,$id_ocupante,$id_responsable,$fecha_inicio,$fecha_fin,$fecha_gracia,$estado_contrato,$estado_pago,$id_contrato]);
    }

    public static function deleteContratoNicho($id)
    {
        return DB::delete('DELETE FROM contrato_nicho WHERE id_contrato = ?', [$id]);
    }

}
