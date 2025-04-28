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
    public function index(Request $request)
    {
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        // Obtener datos para los reportes
        $nichosData = Auditoria::getNichosOcupadosYDisponibles();
        $nichosProximosVencer = Auditoria::getNichosProximosAVencer();
        $contratosVigentesVencidos = Auditoria::getContratosVigentesYVencidos();
        $nichosConPagosPendientes = Auditoria::getNichosConPagosPendientes();
        $exhumacionesDetalles = Auditoria::getExhumacionesDetalles();
        $dineroRecaudado = Auditoria::getDineroRecaudado();
        $totalRecaudado = Auditoria::getTotalDineroRecaudado();
        $contratosProximosVencer = Auditoria::getContratosProximosAVencer();
        $contratosVencidos = Auditoria::getContratosVencidos();
        
        // Para el reporte de exhumaciones por período
        $startDate = $request->input('start_date', Carbon::now()->subMonths(1)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $exhumacionesPeriodo = Auditoria::getExhumacionesPorPeriodo($startDate, $endDate);
        
        // Contar nichos ocupados y disponibles
        $nichosOcupados = 0;
        $nichosDisponibles = 0;
        
        foreach ($nichosData as $nicho) {
            if ($nicho->estado_nicho == 'ocupado') {
                $nichosOcupados++;
            } else {
                $nichosDisponibles++;
            }
        }
        
        return view('admin.gestion_reportes', compact(
            'persona',
            'nichosOcupados',
            'nichosDisponibles',
            'nichosData',
            'nichosProximosVencer',
            'contratosVigentesVencidos',
            'nichosConPagosPendientes',
            'exhumacionesDetalles',
            'dineroRecaudado',
            'totalRecaudado',
            'contratosProximosVencer',
            'contratosVencidos',
            'exhumacionesPeriodo',
            'startDate',
            'endDate'
        ));
    }
}
