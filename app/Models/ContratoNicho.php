<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoNicho extends Model
{
    protected $table = 'contrato_nicho';
    

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


    public static function getAllInfoContratoNicho()
    {
        return DB::select('SELECT * FROM vista_contratos_completa');
    }

    public static function getAllInfoContratoNichoById($id)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE id_contrato = ?', [$id]);
    }

    public static function getAllInfoContratoNichoByNicho($id_nicho)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE id_nicho = ?', [$id_nicho]);
    }

    public static function getAllInfoContratoNichoByEstado($estado)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE estado_contrato = ?', [$estado]);
    }

    public static function getAllInfoContratoNichoByOcupante($id_ocupante)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE id_ocupante = ?', [$id_ocupante]);
    }
    public static function getAllInfoContratoNichoByResponsable($id_responsable)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE id_responsable = ?', [$id_responsable]);
    }

    public static function getAllInfoContratoNichoByResponsableAndEstado($id_responsable, $estado)
    {
        return DB::select('SELECT * FROM vista_contratos_completa WHERE id_responsable = ? AND estado_contrato = ?', [$id_responsable, $estado]);
    }

    public static function rechazarContrato($id_contrato)
    {
        return DB::update('UPDATE contrato_nicho SET estado_contrato = ?, estado_pago = ? WHERE id_contrato = ?', ['rechazado', 'rechazado', $id_contrato]);
    }

    public static function aceptarContrato($id_contrato)
    {
        return DB::update('UPDATE contrato_nicho SET estado_contrato = ?, estado_pago = ? WHERE id_contrato = ?', ['pago_pendiente', 'pago_pendiente', $id_contrato]);
    }

    public static function updateEstadoPagoBoleta($id_contrato)
    {
        return DB::update('UPDATE contrato_nicho SET estado_contrato = ?, estado_pago = ? WHERE id_contrato = ?', ['pago_realizado', 'pago_realizado', $id_contrato]);
    }

}
