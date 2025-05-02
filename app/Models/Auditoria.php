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

    // Obtener estadísticas de edad de los fallecidos
    public static function getEstadisticasEdadFallecidos()
    {
        return DB::select(
            "SELECT 
            TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, o.fecha_fallecimiento) AS edad,
            COUNT(*) AS cantidad
        FROM 
            OCUPANTE o
        INNER JOIN 
            PERSONA p ON o.id_persona = p.id_persona
        WHERE 
            o.fecha_fallecimiento IS NOT NULL
        GROUP BY 
            edad
        ORDER BY 
            edad ASC"
        );
    }

    // Obtener causas de muerte más comunes
    public static function getCausasMuerteMasComunes()
    {
        return DB::select(
            "SELECT 
            t.nombre_causa,
            COUNT(*) AS cantidad
        FROM 
            OCUPANTE o
        INNER JOIN 
            TIPOS_CAUSA_MUERTE t ON o.id_tipo_muerte = t.id_tipo_muerte
        GROUP BY 
            t.nombre_causa
        ORDER BY 
            cantidad DESC"
        );
    }

    public static function getOcupacionPorTipoNicho()
    {
        return DB::select(
            "SELECT 
            tn.nombre_tipo,
            COUNT(CASE WHEN n.estado = 'ocupado' THEN 1 END) AS ocupados,
            COUNT(CASE WHEN n.estado = 'disponible' THEN 1 END) AS disponibles,
            COUNT(*) AS total
        FROM 
            NICHOS n
        INNER JOIN 
            TIPO_NICHO tn ON n.id_tipo_nicho = tn.id_tipo_nicho
        GROUP BY 
            tn.nombre_tipo"
        );
    }

    public static function getTendenciaFallecimientosPorMes()
    {
        return DB::select(
            "SELECT 
            YEAR(o.fecha_fallecimiento) AS anio,
            MONTH(o.fecha_fallecimiento) AS mes,
            COUNT(*) AS cantidad
        FROM 
            OCUPANTE o
        WHERE 
            o.fecha_fallecimiento IS NOT NULL
        GROUP BY 
            anio, mes
        ORDER BY 
            anio DESC, mes ASC"
        );
    }

    public static function getIngresosMensuales()
    {
        return DB::select(
            "SELECT 
            YEAR(fecha_emision) AS anio,
            MONTH(fecha_emision) AS mes,
            SUM(total) AS ingreso_total
        FROM 
            BOLETA_PAGO
        WHERE 
            estado = 'pagado'
        GROUP BY 
            anio, mes
        ORDER BY 
            anio DESC, mes ASC"
        );
    }

    // Obtener distribución de auditorías por tipo de problema
    public static function getAuditoriasPorTipoProblema()
    {
        return DB::select(
            "SELECT 
            tipo_problema,
            COUNT(*) AS cantidad
        FROM 
            AUDITORIA
        GROUP BY 
            tipo_problema
        ORDER BY 
            cantidad DESC"
        );
    }

    public static function getRendimientoAuditores()
    {
        return DB::select(
            "SELECT 
            p.nombre,
            p.apellido,
            COUNT(*) AS auditorias_realizadas
        FROM 
            AUDITORIA a
        INNER JOIN 
            PERSONA p ON a.id_auditor = p.id_persona
        GROUP BY 
            p.id_persona
        ORDER BY 
            auditorias_realizadas DESC"
        );
    }


    public static function crearAuditoria($id_contrato, $tipo_problema, $id_auditor, $detalles_auditoria)
    {
        return DB::insert(
            "INSERT INTO AUDITORIA (id_contrato, tipo_problema, id_auditor, detalles_auditoria, estado) 
            VALUES (?, ?, ?, ?, 'pendiente')",
            [$id_contrato, $tipo_problema, $id_auditor, $detalles_auditoria]
        );
    }

    public static function getAuditorias()
    {
        return DB::select(
            "SELECT 
            a.id_auditoria,
            a.tipo_problema,
            a.fecha_hora,
            a.detalles_auditoria,
            a.estado,
            p.nombre AS auditor_nombre,
            p.apellido AS auditor_apellido,
            cn.id_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            n.descripcion AS descripcion_nicho
        FROM 
            AUDITORIA a
        INNER JOIN 
            PERSONA p ON a.id_auditor = p.id_persona
        INNER JOIN 
            CONTRATO_NICHO cn ON a.id_contrato = cn.id_contrato
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho"
        );

    }

    public static function getAuditoriasByIdPersona($id_persona)
    {
        return DB::select(
            "SELECT 
            a.id_auditoria,
            a.tipo_problema,
            a.fecha_hora,
            a.detalles_auditoria,
            a.estado,
            p.nombre AS auditor_nombre,
            p.apellido AS auditor_apellido,
            cn.id_contrato,
            cn.fecha_inicio,
            cn.fecha_fin,
            n.descripcion AS descripcion_nicho
        FROM 
            AUDITORIA a
        INNER JOIN 
            PERSONA p ON a.id_auditor = p.id_persona
        INNER JOIN 
            CONTRATO_NICHO cn ON a.id_contrato = cn.id_contrato
        INNER JOIN 
            NICHOS n ON cn.id_nicho = n.id_nicho
        WHERE 
            a.id_auditor = ?",
            [$id_persona]
        );

    }

}
