<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    //
    public static function getNichosOcupadosYDisponibles()
    {
        return DB::select(
            "SELECT 
            n.id_nicho,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho,
            t.nombre_tipo AS tipo_nicho,
            CONCAT(c.nombre_calle, ', ', a.nombre_avenida) AS ubicacion,
            un.descripcion AS ubicacion_detalle
        FROM 
            NICHOS n
        INNER JOIN 
            TIPO_NICHO t ON n.id_tipo_nicho = t.id_tipo_nicho
        INNER JOIN 
            UBICACION_NICHO un ON n.id_ubicacion_nicho = un.id_ubicacion_nicho
        INNER JOIN 
            CALLE c ON un.id_calle = c.id_calle
        INNER JOIN 
            AVENIDA a ON un.id_avenida = a.id_avenida"
        );

    }

    public static  function getExhumacionesPorPeriodo($startDate, $endDate)
    {
        return DB::select(
            "SELECT 
            re.id_exhumacion,
            re.persona_solicitante,
            re.id_persona_solicitante,
            re.motivo,
            re.fecha_exhumacion,
            re.estado AS estado_exhumacion,
            p.nombre AS solicitante_nombre,
            p.apellido AS solicitante_apellido,
            cn.id_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            n.descripcion AS descripcion_nicho
        FROM 
            REGISTRO_EXHUMACIONES re
        INNER JOIN 
            PERSONA p ON re.id_persona_solicitante = p.id_persona
        INNER JOIN 
            CONTRATO_NICHO cn ON re.id_contrato = cn.id_contrato
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            re.fecha_exhumacion BETWEEN ? AND ?",
            [$startDate, $endDate]
        );

    }

    public static function getNichosProximosAVencer()
    {
        return DB::select(
            "SELECT 
            cn.id_contrato,
            cn.estado_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho,
            t.nombre_tipo AS tipo_nicho
        FROM 
            CONTRATO_NICHO cn
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        INNER JOIN 
            TIPO_NICHO t ON n.id_tipo_nicho = t.id_tipo_nicho
        WHERE 
            cn.fecha_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
        );

    }

    public static function getContratosVigentesYVencidos()
    {
        return DB::select(
            "SELECT 
            cn.id_contrato,
            cn.estado_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho
        FROM 
            CONTRATO_NICHO cn
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho"
        );

    }

    public static function getNichosConPagosPendientes()
    {
        return DB::select(
            "SELECT 
            bp.id_boleta,
            bp.total,
            bp.estado AS estado_pago,
            bp.fecha_emision,
            cn.id_contrato,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho
        FROM 
            BOLETA_PAGO bp
        INNER JOIN 
            CONTRATO_NICHO cn ON bp.id_contrato = cn.id_contrato
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            bp.estado = 'pago_pendiente'"
        );

    }

    public static function getExhumacionesDetalles()
    {
        return DB::select(
            "SELECT 
                re.id_exhumacion,
                re.persona_solicitante,
                re.id_persona_solicitante,
                re.motivo,
                re.fecha_exhumacion,
                re.estado AS estado_exhumacion,
                p.nombre AS solicitante_nombre,
                p.apellido AS solicitante_apellido,
                n.descripcion AS descripcion_nicho,
                cn.fecha_inicio,
                cn.fecha_fin,
                cn.id_contrato
            FROM 
                REGISTRO_EXHUMACIONES re
            INNER JOIN 
                PERSONA p ON re.id_persona_solicitante = p.id_persona
            INNER JOIN 
                CONTRATO_NICHO cn ON re.id_contrato = cn.id_contrato
            INNER JOIN 
                NICHOS n ON cn.id_nicho = n.id_nicho"
        );

    }

    public static  function getDineroRecaudado()
    {
        return DB::select(
            "SELECT 
            bp.id_boleta,
            bp.total,
            bp.fecha_emision,
            bp.estado AS estado_pago,
            cn.id_contrato,
            cn.estado_contrato,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho
        FROM 
            BOLETA_PAGO bp
        INNER JOIN 
            CONTRATO_NICHO cn ON bp.id_contrato = cn.id_contrato
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            bp.estado = 'pagado'"
        );

    }

    public static function getTotalDineroRecaudado()
    {
        return DB::select(
            "SELECT 
            SUM(total) AS total_recaudado
        FROM 
            BOLETA_PAGO
        WHERE 
            estado = 'pagado'"
        );

    }

    public static function getContratosProximosAVencer()
    {
        return DB::select(
            "SELECT 
            cn.id_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            cn.estado_contrato,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho
        FROM 
            CONTRATO_NICHO cn
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            cn.fecha_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
        );

    }

    public static  function getContratosVencidos()
    {
        return DB::select(
            "SELECT 
            cn.id_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            cn.estado_contrato,
            n.descripcion AS descripcion_nicho,
            n.estado AS estado_nicho
        FROM 
            CONTRATO_NICHO cn
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            cn.estado_contrato = 'vencido'"
        );

    }


    
    public static function getTotalNichosByEstado($estado)
    {
        $total = DB::select(
            "SELECT 
            COUNT(*) AS total_nichos
        FROM
        nichos WHERE estado = ?",
            [$estado]
        );

        return $total[0]->total_nichos;

    }

    public static function getTotalContratosByEstado($estado)
    {
        $total = DB::select(
            "SELECT 
            COUNT(*) AS total_contratos
        FROM 
            CONTRATO_NICHO
        WHERE 
            estado_contrato = ?",
            [$estado]
        );

        return $total[0]->total_contratos;

    }


}
