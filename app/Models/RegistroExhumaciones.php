<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegistroExhumaciones extends Model
{
    //
    /*
    CREATE TABLE REGISTRO_EXHUMACIONES (
    id_exhumacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    persona_solicitante VARCHAR(100),
    id_persona_solicitante INT,
    motivo TEXT,
    fecha_exhumacion DATE,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato),
    FOREIGN KEY (id_persona_solicitante) REFERENCES PERSONA(id_persona)
);
);
    */
    public static function registrarExhumacion($id_contrato, $fecha_exhumacion, $motivo, $id_persona_solicitante, $nombre_solicitante)
    {
        $estado = 'solicitado';
        return DB::insert('INSERT INTO REGISTRO_EXHUMACIONES (id_contrato, persona_solicitante, id_persona_solicitante, motivo, fecha_exhumacion, estado) VALUES (?, ?, ?, ?, ?, ?)', [$id_contrato, $nombre_solicitante, $id_persona_solicitante, $motivo, $fecha_exhumacion, $estado]);
    }

    public static function getAllInfoExhumaciones()
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion');
    }


    public static function getAllInfoExhumacionesByIdPersona($id_persona)
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion WHERE id_responsable = ?', [$id_persona]);
    }

    public static function getAllInfoExhumacionesByIdContrato($id_contrato)
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion WHERE id_contrato = ?', [$id_contrato]);
    }

    public static function getAllInfoExhumacionesByIdExhumacion($id_exhumacion)
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion WHERE id_exhumacion = ?', [$id_exhumacion]);
    }

    public static function getAllInfoExhumacionesByIdNicho($id_nicho)
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion WHERE id_nicho = ?', [$id_nicho]);
    }

    public static function getAllInfoExhumacionesByEstado($estado)
    {
        return DB::select('SELECT * FROM vista_contratos_exhumacion WHERE estado_exhumacion = ?', [$estado]);
    }

    public static function aceptarExhumacion($id_exhumacion)
    {
        try{
            DB::statement('CALL actualizarEstadoExhumacion(?, ?)', [$id_exhumacion, 'aceptada']);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function rechazarExhumacion($id_exhumacion)
    {
        try{
            DB::statement('CALL actualizarEstadoExhumacion(?, ?)', [$id_exhumacion, 'rechazada']);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

}
