@extends('layouts.admin')

@section('titulo', 'Gestión de Reportes')

@section('titulo_seccion', 'Gestión de Reportes')

@section('estilos')
<style>
    .card-dashboard {
        border-left: 4px solid #3e6b89;
        transition: all 0.3s ease;
        height: 100%;
    }
    .card-dashboard:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stats-icon {
        font-size: 2rem;
        color: #3e6b89;
    }
    .nav-tabs .nav-link {
        color: #495057;
    }
    .nav-tabs .nav-link.active {
        color: #3e6b89;
        font-weight: bold;
        border-bottom: 3px solid #3e6b89;
    }
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    .filter-container {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('contenido')
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Nichos Ocupados</h5>
                        <h2 class="mb-0">{{ $nichosOcupados }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-monument"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Nichos Disponibles</h5>
                        <h2 class="mb-0">{{ $nichosDisponibles }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card card-dashboard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Recaudado</h5>
                        <h2 class="mb-0">Q
                            @if(!empty($totalRecaudado) && count($totalRecaudado) > 0)
                                {{ number_format($totalRecaudado[0]->total_recaudado, 2) }}
                            @else
                                0.00
                            @endif
                        </h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="reportesTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="nichos-tab" data-bs-toggle="tab" href="#nichos" role="tab">Nichos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contratos-tab" data-bs-toggle="tab" href="#contratos" role="tab">Contratos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pagos-tab" data-bs-toggle="tab" href="#pagos" role="tab">Pagos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="exhumaciones-tab" data-bs-toggle="tab" href="#exhumaciones" role="tab">Exhumaciones</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="reportesTabsContent">
            <!-- Nichos Tab -->
            <div class="tab-pane fade show active" id="nichos" role="tabpanel">
                <h4 class="mb-3">Listado de Nichos</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Ubicación</th>
                                <th>Ubicación Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nichosData as $nicho)
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

                <h4 class="mt-4 mb-3">Nichos Próximos a Vencer</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Estado Contrato</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Descripción Nicho</th>
                                <th>Estado Nicho</th>
                                <th>Tipo Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nichosProximosVencer as $nicho)
                            <tr>
                                <td>{{ $nicho->id_contrato }}</td>
                                <td>{{ $nicho->estado_contrato }}</td>
                                <td>{{ $nicho->fecha_inicio }}</td>
                                <td>{{ $nicho->fecha_fin }}</td>
                                <td>{{ $nicho->descripcion_nicho }}</td>
                                <td>
                                    @if($nicho->estado_nicho == 'ocupado')
                                        <span class="badge bg-danger">Ocupado</span>
                                    @else
                                        <span class="badge bg-success">Disponible</span>
                                    @endif
                                </td>
                                <td>{{ $nicho->tipo_nicho }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contratos Tab -->
            <div class="tab-pane fade" id="contratos" role="tabpanel">
                <h4 class="mb-3">Contratos Vigentes y Vencidos</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Estado</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Descripción Nicho</th>
                                <th>Estado Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratosVigentesVencidos as $contrato)
                            <tr>
                                <td>{{ $contrato->id_contrato }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Vigente</span>
                                    @elseif($contrato->estado_contrato == 'vencido')
                                        <span class="badge bg-danger">Vencido</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
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

                <h4 class="mt-4 mb-3">Contratos Próximos a Vencer (30 días)</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Estado</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Descripción Nicho</th>
                                <th>Estado Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratosProximosVencer as $contrato)
                            <tr>
                                <td>{{ $contrato->id_contrato }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Vigente</span>
                                    @elseif($contrato->estado_contrato == 'vencido')
                                        <span class="badge bg-danger">Vencido</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
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

            <!-- Pagos Tab -->
            <div class="tab-pane fade" id="pagos" role="tabpanel">
                <h4 class="mb-3">Nichos con Pagos Pendientes</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Boleta</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha Emisión</th>
                                <th>ID Contrato</th>
                                <th>Descripción Nicho</th>
                                <th>Estado Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nichosConPagosPendientes as $pago)
                            <tr>
                                <td>{{ $pago->id_boleta }}</td>
                                <td>Q{{ number_format($pago->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                </td>
                                <td>{{ $pago->fecha_emision }}</td>
                                <td>{{ $pago->id_contrato }}</td>
                                <td>{{ $pago->descripcion_nicho }}</td>
                                <td>
                                    @if($pago->estado_nicho == 'ocupado')
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

                <h4 class="mt-4 mb-3">Dinero Recaudado</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <h5 class="card-title">Total Recaudado</h5>
                                <h2 class="mb-0">Q
                                    @if(!empty($totalRecaudado) && count($totalRecaudado) > 0)
                                        {{ number_format($totalRecaudado[0]->total_recaudado, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Boleta</th>
                                <th>Total</th>
                                <th>Fecha Emisión</th>
                                <th>Estado</th>
                                <th>ID Contrato</th>
                                <th>Estado Contrato</th>
                                <th>Descripción Nicho</th>
                                <th>Estado Nicho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dineroRecaudado as $pago)
                            <tr>
                                <td>{{ $pago->id_boleta }}</td>
                                <td>Q{{ number_format($pago->total, 2) }}</td>
                                <td>{{ $pago->fecha_emision }}</td>
                                <td>
                                    <span class="badge bg-success">Pagado</span>
                                </td>
                                <td>{{ $pago->id_contrato }}</td>
                                <td>
                                    @if($pago->estado_contrato == 'activo')
                                        <span class="badge bg-success">Vigente</span>
                                    @elseif($pago->estado_contrato == 'vencido')
                                        <span class="badge bg-danger">Vencido</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $pago->estado_contrato }}</span>
                                    @endif
                                </td>
                                <td>{{ $pago->descripcion_nicho }}</td>
                                <td>
                                    @if($pago->estado_nicho == 'ocupado')
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

            <!-- Exhumaciones Tab -->
            <div class="tab-pane fade" id="exhumaciones" role="tabpanel">
                <h4 class="mb-3">Exhumaciones por Período</h4>
                <div class="filter-container">
                    <form action="{{ route('admin.gestion_reportes') }}" method="GET" class="row align-items-end">
                        <div class="col-md-4 mb-2">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Solicitante</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Nicho</th>
                                <th>Contrato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exhumacionesPeriodo as $exhum)
                            <tr>
                                <td>{{ $exhum->id_exhumacion }}</td>
                                <td>{{ $exhum->fecha_exhumacion }}</td>
                                <td>{{ $exhum->solicitante_nombre }} {{ $exhum->solicitante_apellido }}</td>
                                <td>{{ $exhum->motivo }}</td>
                                <td>
                                    @if($exhum->estado_exhumacion == 'aceptada')
                                        <span class="badge bg-success">Aprobada</span>
                                    @elseif($exhum->estado_exhumacion == 'solicitado')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($exhum->estado_exhumacion == 'rechazada')
                                        <span class="badge bg-danger">Rechazada</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $exhum->estado_exhumacion }}</span>
                                    @endif
                                </td>
                                <td>{{ $exhum->descripcion_nicho }}</td>
                                <td>{{ $exhum->id_contrato }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 class="mt-4 mb-3">Registro de Exhumaciones</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Solicitante</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Nicho</th>
                                <th>Contrato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exhumacionesDetalles as $exhum)
                            <tr>
                                <td>{{ $exhum->id_exhumacion }}</td>
                                <td>{{ $exhum->fecha_exhumacion }}</td>
                                <td>{{ $exhum->solicitante_nombre }} {{ $exhum->solicitante_apellido }}</td>
                                <td>{{ $exhum->motivo }}</td>
                                <td>
                                    @if($exhum->estado_exhumacion == 'aprobada')
                                        <span class="badge bg-success">Aprobada</span>
                                    @elseif($exhum->estado_exhumacion == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($exhum->estado_exhumacion == 'rechazada')
                                        <span class="badge bg-danger">Rechazada</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $exhum->estado_exhumacion }}</span>
                                    @endif
                                </td>
                                <td>{{ $exhum->descripcion_nicho }}</td>
                                <td>{{ $exhum->id_contrato }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activar los tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection