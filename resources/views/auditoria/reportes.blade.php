@extends('layouts.auditoria')

@section('titulo')
Reportes
@endsection

@section('titulo_seccion')
<i class="fas fa-chart-bar me-2"></i> Panel de Reportes
@endsection

@section('estilos')
<style>
    .nav-tabs .nav-link {
        color: #3e6b89;
        border: 1px solid #dee2e6;
        margin-right: 5px;
    }
    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #3e6b89;
        border-color: #3e6b89;
    }
    .tab-pane {
        padding: 20px;
        border: 1px solid #dee2e6;
        border-top: none;
    }
    .dashboard-card {
        border-left: 4px solid #3e6b89;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .table-container {
        overflow-x: auto;
    }
    .stat-card {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #3e6b89;
    }
    .stat-card h3 {
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #3e6b89;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2c4d63;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .report-section {
        margin-bottom: 30px;
    }
    .bg-soft-primary {
        background-color: rgba(62, 107, 137, 0.1);
    }
    .text-primary {
        color: #3e6b89 !important;
    }
    .border-primary {
        border-color: #3e6b89 !important;
    }
</style>
@endsection

@section('contenido')

<!-- Resumen Estadístico -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Nichos Ocupados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_nichos_ocupados'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bed fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Nichos Disponibles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_nichos_disponibles'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Contratos Vigentes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_contratos_vigentes'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-contract fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Contratos Vencidos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_contratos_vencidos'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navegación de Pestañas -->
<ul class="nav nav-tabs" id="reportsTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="nichos-tab" data-bs-toggle="tab" data-bs-target="#nichos" type="button" role="tab" aria-controls="nichos" aria-selected="true">
            <i class="fas fa-box me-1"></i> Nichos
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contratos-tab" data-bs-toggle="tab" data-bs-target="#contratos" type="button" role="tab" aria-controls="contratos" aria-selected="false">
            <i class="fas fa-file-contract me-1"></i> Contratos
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="finanzas-tab" data-bs-toggle="tab" data-bs-target="#finanzas" type="button" role="tab" aria-controls="finanzas" aria-selected="false">
            <i class="fas fa-dollar-sign me-1"></i> Finanzas
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="exhumaciones-tab" data-bs-toggle="tab" data-bs-target="#exhumaciones" type="button" role="tab" aria-controls="exhumaciones" aria-selected="false">
            <i class="fas fa-procedures me-1"></i> Exhumaciones
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="demograficos-tab" data-bs-toggle="tab" data-bs-target="#demograficos" type="button" role="tab" aria-controls="demograficos" aria-selected="false">
            <i class="fas fa-users me-1"></i> Demográficos
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="auditorias-tab" data-bs-toggle="tab" data-bs-target="#auditorias" type="button" role="tab" aria-controls="auditorias" aria-selected="false">
            <i class="fas fa-clipboard-check me-1"></i> Auditorías
        </button>
    </li>
</ul>

<!-- Contenido de las Pestañas -->
<div class="tab-content" id="reportsTabsContent">
    <!-- Pestaña de Nichos -->
    <div class="tab-pane fade show active" id="nichos" role="tabpanel" aria-labelledby="nichos-tab">
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box me-2"></i>Estado de Nichos
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Ubicación</th>
                                <th>Detalle Ubicación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['nichos_ocupados_disponibles'] as $nicho)
                            <tr>
                                <td>{{ $nicho->id_nicho }}</td>
                                <td>{{ $nicho->descripcion_nicho }}</td>
                                <td>
                                    @if($nicho->estado_nicho == 'ocupado')
                                        <span class="badge bg-danger">Ocupado</span>
                                    @else
                                        <span class="badge bg-success">Disponible</span>
                                    @endif
                                </td>
                                <td>{{ $nicho->tipo_nicho }}</td>
                                <td>{{ $nicho->ubicacion }}</td>
                                <td>{{ $nicho->ubicacion_detalle }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Ocupación por Tipo de Nicho
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo de Nicho</th>
                                <th>Ocupados</th>
                                <th>Disponibles</th>
                                <th>Total</th>
                                <th>% Ocupación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['ocupacion_por_tipo_nicho'] as $ocupacion)
                            <tr>
                                <td>{{ $ocupacion->nombre_tipo }}</td>
                                <td>{{ $ocupacion->ocupados }}</td>
                                <td>{{ $ocupacion->disponibles }}</td>
                                <td>{{ $ocupacion->total }}</td>
                                <td>
                                    @php
                                        $porcentaje = $ocupacion->total > 0 ? round(($ocupacion->ocupados / $ocupacion->total) * 100, 2) : 0;
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">{{ $porcentaje }}%</div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pestaña de Contratos -->
    <div class="tab-pane fade" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-contract me-2"></i>Contratos Vigentes y Vencidos
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Estado</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Nicho</th>
                                <th>Estado Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['contratos_vigentes_vencidos'] as $contrato)
                            <tr>
                                <td>{{ $contrato->id_contrato }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Vigente</span>
                                    @else
                                        <span class="badge bg-danger">Vencido</span>
                                    @endif
                                </td>
                                <td>{{ $contrato->fecha_inicio }}</td>
                                <td>{{ $contrato->fecha_fin }}</td>
                                <td>{{ $contrato->descripcion_nicho }}</td>
                                <td>
                                    @if($contrato->estado_nicho == 'ocupado')
                                        <span class="badge bg-danger">Ocupado</span>
                                    @else
                                        <span class="badge bg-success">Disponible</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>Contratos Próximos a Vencer (30 días)
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th>Nicho</th>
                                <th>Días Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['contratos_proximos_vencer'] as $contrato)
                            @php
                                $fechaFin = new DateTime($contrato->fecha_fin);
                                $fechaActual = new DateTime();
                                $diasRestantes = $fechaActual->diff($fechaFin)->days;
                            @endphp
                            <tr>
                                <td>{{ $contrato->id_contrato }}</td>
                                <td>{{ $contrato->fecha_inicio }}</td>
                                <td>{{ $contrato->fecha_fin }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Vigente</span>
                                    @else
                                        <span class="badge bg-danger">Vencido</span>
                                    @endif
                                </td>
                                <td>{{ $contrato->descripcion_nicho }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $diasRestantes }} días</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pestaña de Finanzas -->
    <div class="tab-pane fade" id="finanzas" role="tabpanel" aria-labelledby="finanzas-tab">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 dashboard-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Recaudado
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Q{{ number_format($data['total_dinero_recaudado'][0]->total_recaudado, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-money-bill-wave me-2"></i>Pagos Realizados
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Boleta</th>
                                <th>Total</th>
                                <th>Fecha Emisión</th>
                                <th>Estado</th>
                                <th>ID Contrato</th>
                                <th>Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['dinero_recaudado'] as $pago)
                            <tr>
                                <td>{{ $pago->id_boleta }}</td>
                                <td>Q{{ number_format($pago->total, 2) }}</td>
                                <td>{{ $pago->fecha_emision }}</td>
                                <td>
                                    <span class="badge bg-success">Pagado</span>
                                </td>
                                <td>{{ $pago->id_contrato }}</td>
                                <td>{{ $pago->descripcion_nicho }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>Pagos Pendientes
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Boleta</th>
                                <th>Total</th>
                                <th>Fecha Emisión</th>
                                <th>Estado</th>
                                <th>ID Contrato</th>
                                <th>Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['nichos_pagos_pendientes'] as $pago)
                            <tr>
                                <td>{{ $pago->id_boleta }}</td>
                                <td>Q{{ number_format($pago->total, 2) }}</td>
                                <td>{{ $pago->fecha_emision }}</td>
                                <td>
                                    <span class="badge bg-danger">Pendiente</span>
                                </td>
                                <td>{{ $pago->id_contrato }}</td>
                                <td>{{ $pago->descripcion_nicho }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestaña de Exhumaciones -->
    <div class="tab-pane fade" id="exhumaciones" role="tabpanel" aria-labelledby="exhumaciones-tab">
        <div class="card dashboard-card">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-procedures me-2"></i>Registro de Exhumaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Nicho</th>
                                <th>Contrato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['exhumaciones_detalles'] as $exhumacion)
                            <tr>
                                <td>{{ $exhumacion->id_exhumacion }}</td>
                                <td>{{ $exhumacion->solicitante_nombre }} {{ $exhumacion->solicitante_apellido }}</td>
                                <td>{{ $exhumacion->motivo }}</td>
                                <td>{{ $exhumacion->fecha_exhumacion }}</td>
                                <td>
                                    @if($exhumacion->estado_exhumacion == 'aceptada')
                                        <span class="badge bg-success">Completada</span>
                                    @elseif($exhumacion->estado_exhumacion == 'solicitado')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $exhumacion->estado_exhumacion }}</span>
                                    @endif
                                </td>
                                <td>{{ $exhumacion->descripcion_nicho }}</td>
                                <td>{{ $exhumacion->id_contrato }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
    </div>
    
    <!-- Pestaña de Demográficos -->
    <div class="tab-pane fade" id="demograficos" role="tabpanel" aria-labelledby="demograficos-tab">
        <div class="row">
            
            
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-light">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-heartbeat me-2"></i>Causas de Muerte Más Comunes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Causa</th>
                                        <th>Cantidad</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalCausas = array_sum(array_column($data['causas_muerte_comunes'], 'cantidad'));
                                    @endphp
                                    @foreach($data['causas_muerte_comunes'] as $causa)
                                    <tr>
                                        <td>{{ $causa->nombre_causa }}</td>
                                        <td>{{ $causa->cantidad }}</td>
                                        <td>
                                            @php
                                                $porcentaje = $totalCausas > 0 ? round(($causa->cantidad / $totalCausas) * 100, 2) : 0;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">{{ $porcentaje }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card dashboard-card">
            <div class="card-header bg-light">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Tendencia de Fallecimientos por Mes
                </h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Año</th>
                                <th>Mes</th>
                                <th>Cantidad</th>
                                <th>Tendencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['tendencia_fallecimientos'] as $tendencia)
                            <tr>
                                <td>{{ $tendencia->anio }}</td>
                                <td>
                                    @php
                                        $meses = [
                                            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 
                                            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                                            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 
                                            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                        ];
                                    @endphp
                                    {{ $meses[$tendencia->mes] }}
                                </td>
                                <td>{{ $tendencia->cantidad }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ min($tendencia->cantidad * 5, 100) }}%;" aria-valuenow="{{ $tendencia->cantidad }}" aria-valuemin="0" aria-valuemax="100">{{ $tendencia->cantidad }}</div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pestaña de Auditorías -->
    <div class="tab-pane fade" id="auditorias" role="tabpanel" aria-labelledby="auditorias-tab">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-light">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-exclamation-triangle me-2"></i>Tipos de Problemas Auditados
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo de Problema</th>
                                        <th>Cantidad</th>
                                        <th>Distribución</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalProblemas = array_sum(array_column($data['auditorias_por_problema'], 'cantidad'));
                                    @endphp
                                    @foreach($data['auditorias_por_problema'] as $problema)
                                    <tr>
                                        <td>{{ $problema->tipo_problema }}</td>
                                        <td>{{ $problema->cantidad }}</td>
                                        <td>
                                            @php
                                                $porcentaje = $totalProblemas > 0 ? round(($problema->cantidad / $totalProblemas) * 100, 2) : 0;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">{{ $porcentaje }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-light">
                        <h5 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-shield me-2"></i>Rendimiento de Auditores
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Auditor</th>
                                        <th>Auditorías Realizadas</th>
                                        <th>Rendimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $maxAuditorias = count($data['rendimiento_auditores']) > 0 ? 
                                            max(array_column($data['rendimiento_auditores'], 'auditorias_realizadas')) : 1;
                                    @endphp
                                    @foreach($data['rendimiento_auditores'] as $auditor)
                                    <tr>
                                        <td>{{ $auditor->nombre }} {{ $auditor->apellido }}</td>
                                        <td>{{ $auditor->auditorias_realizadas }}</td>
                                        <td>
                                            @php
                                                $porcentaje = $maxAuditorias > 0 ? round(($auditor->auditorias_realizadas / $maxAuditorias) * 100, 2) : 0;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">{{ $porcentaje }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
        