<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autenticacion;
use App\Models\Persona;
use App\Models\Auditoria;
class AuditarReportesController extends Controller
{
    //
    public function index()
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        $data = [
            // Nichos y contratos
            'nichos_ocupados_disponibles' => Auditoria::getNichosOcupadosYDisponibles(),
            'contratos_vigentes_vencidos' => Auditoria::getContratosVigentesYVencidos(),
            'contratos_proximos_vencer' => Auditoria::getContratosProximosAVencer(),
            'contratos_vencidos' => Auditoria::getContratosVencidos(),
            'ocupacion_por_tipo_nicho' => Auditoria::getOcupacionPorTipoNicho(),
            
            // Pagos y finanzas
            'nichos_pagos_pendientes' => Auditoria::getNichosConPagosPendientes(),
            'dinero_recaudado' => Auditoria::getDineroRecaudado(),
            'total_dinero_recaudado' => Auditoria::getTotalDineroRecaudado(),
            'ingresos_mensuales' => Auditoria::getIngresosMensuales(),
            
            // Exhumaciones
            'exhumaciones_detalles' => Auditoria::getExhumacionesDetalles(),
            
            // Estadísticas demográficas
            //'estadisticas_edad_fallecidos' => Auditoria::getEstadisticasEdadFallecidos(),
            'causas_muerte_comunes' => Auditoria::getCausasMuerteMasComunes(),
            'tendencia_fallecimientos' => Auditoria::getTendenciaFallecimientosPorMes(),
            
            // Auditorías
            'auditorias_por_problema' => Auditoria::getAuditoriasPorTipoProblema(),
            'rendimiento_auditores' => Auditoria::getRendimientoAuditores(),
            
            // Contadores
            'total_nichos_ocupados' => Auditoria::getTotalNichosByEstado('ocupado'),
            'total_nichos_disponibles' => Auditoria::getTotalNichosByEstado('disponible'),
            'total_contratos_vigentes' => Auditoria::getTotalContratosByEstado('activo'),
            'total_contratos_vencidos' => Auditoria::getTotalContratosByEstado('vencido')
        ];


        return view('auditoria.reportes', compact('persona', 'data'));
    
    }
}
