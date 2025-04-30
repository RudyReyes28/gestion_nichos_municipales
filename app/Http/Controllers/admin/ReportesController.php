<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditoria;
use App\Models\Persona;
use Carbon\Carbon;
class ReportesController extends Controller
{
    //
    public function index()
    {
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        // Obtener datos para todos los reportes
        // 1. Nichos ocupados y disponibles
        $nichosInfo = Auditoria::getNichosOcupadosYDisponibles();
        $nichosOcupados = 0;
        $nichosDisponibles = 0;
        
        foreach ($nichosInfo as $nicho) {
            if ($nicho->estado_nicho === 'ocupado') {
                $nichosOcupados++;
            } else {
                $nichosDisponibles++;
            }
        }
        
        // 2. Contratos vigentes y vencidos
        $contratos = Auditoria::getContratosVigentesYVencidos();
        $contratosVigentes = 0;
        $contratosVencidos = 0;
        
        foreach ($contratos as $contrato) {
            if ($contrato->estado_contrato === 'activo') {
                $contratosVigentes++;
            } else if ($contrato->estado_contrato === 'vencido') {
                $contratosVencidos++;
            }
        }
        
        // 3. Nichos con pagos pendientes
        $nichosPagosPendientes = Auditoria::getNichosConPagosPendientes();
        
        // 4. Exhumaciones realizadas (últimos 30 días por defecto)
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $endDate = date('Y-m-d');
        $exhumacionesRecientes = Auditoria::getExhumacionesPorPeriodo($startDate, $endDate);
        
        // 5. Nichos próximos a vencer
        $nichosProximosVencer = Auditoria::getNichosProximosAVencer();
        
        // 6. Dinero recaudado
        $dineroRecaudado = Auditoria::getDineroRecaudado();
        $totalDineroRecaudado = Auditoria::getTotalDineroRecaudado();
        
        // 7. Exhumaciones con detalles
        $exhumacionesDetalles = Auditoria::getExhumacionesDetalles();
        
        // 8. Contratos próximos a vencer
        $contratosProximosVencer = Auditoria::getContratosProximosAVencer();
        
        // 9. Contratos vencidos
        $contratosVencidos = Auditoria::getContratosVencidos();

        return view('admin.gestion_reportes', compact(
            'persona',
            'nichosOcupados',
            'nichosDisponibles',
            'nichosInfo',
            'contratosVigentes',
            'contratosVencidos',
            'contratos',
            'nichosPagosPendientes',
            'exhumacionesRecientes',
            'nichosProximosVencer',
            'dineroRecaudado',
            'totalDineroRecaudado',
            'exhumacionesDetalles',
            'contratosProximosVencer',
            'startDate',
            'endDate'
        ));
    }

    
}
