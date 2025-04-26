<!-- resources/views/usuario/misExhumaciones.blade.php -->
@extends('layouts.usuario')

@section('titulo', 'Mis Exhumaciones')

@section('titulo_seccion', 'Mis Solicitudes de Exhumación')

@section('contenido')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Listado de Solicitudes</h5>
            <a href="{{ route('usuario.exhumacion') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Nueva Solicitud
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(count($misExhumaciones) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Exhumación</th>
                            <th>Ocupante</th>
                            <th>Ubicación</th>
                            <th>Fecha Solicitud</th>
                            <th>Fecha Exhumación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($misExhumaciones as $exhumacion)
                            <tr>
                                <td>#{{ $exhumacion->id_exhumacion }}</td>
                                <td>{{ $exhumacion->nombre_ocupante }} {{ $exhumacion->apellido_ocupante }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $exhumacion->descripcion_nicho }}</span><br>
                                    <small>{{ $exhumacion->descripcion_ubicacion ?? 'N/A' }}</small>
                                </td>
                                <td>{{ isset($exhumacion->created_at) ? \Carbon\Carbon::parse($exhumacion->created_at)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($exhumacion->fecha_exhumacion)->format('d/m/Y') }}</td>
                                <td>
                                    @if($exhumacion->estado_exhumacion == 'aprobada')
                                        <span class="badge bg-success">Aprobada</span>
                                    @elseif($exhumacion->estado_exhumacion == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($exhumacion->estado_exhumacion == 'rechazada')
                                        <span class="badge bg-danger">Rechazada</span>
                                    @elseif($exhumacion->estado_exhumacion == 'completada')
                                        <span class="badge bg-primary">Completada</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $exhumacion->estado_exhumacion }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#detallesExhumacionModal{{ $exhumacion->id_exhumacion }}">
                                        <i class="fas fa-search"></i> Ver Detalles
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary mb-1" data-bs-toggle="modal" data-bs-target="#detallesContratoModal{{ $exhumacion->id_contrato }}">
                                        <i class="fas fa-file-contract"></i> Ver Contrato
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No tiene solicitudes de exhumación registradas.
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('usuario.exhumacion') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Crear Nueva Solicitud
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modales para cada exhumación -->
@foreach($misExhumaciones as $exhumacion)
    <!-- Modal de detalles de exhumación -->
    <div class="modal fade" id="detallesExhumacionModal{{ $exhumacion->id_exhumacion }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>Detalles de la Exhumación #{{ $exhumacion->id_exhumacion }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Información de la Solicitud</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>ID Exhumación:</strong> {{ $exhumacion->id_exhumacion }}</p>
                            <p><strong>ID Contrato:</strong> {{ $exhumacion->id_contrato }}</p>
                            <p><strong>Fecha Solicitada:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_exhumacion)->format('d/m/Y') }}</p>
                            <p>
                                <strong>Estado:</strong>
                                @if($exhumacion->estado_exhumacion == 'aprobada')
                                    <span class="badge bg-success">Aprobada</span>
                                @elseif($exhumacion->estado_exhumacion == 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif($exhumacion->estado_exhumacion == 'rechazada')
                                    <span class="badge bg-danger">Rechazada</span>
                                @elseif($exhumacion->estado_exhumacion == 'completada')
                                    <span class="badge bg-primary">Completada</span>
                                @else
                                    <span class="badge bg-secondary">{{ $exhumacion->estado_exhumacion }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Motivo de la Exhumación</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $exhumacion->motivo }}</p>
                        </div>
                    </div>

                    @if($exhumacion->estado_exhumacion == 'rechazada')
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Motivo de rechazo:</strong>
                            <p class="mb-0">{{ $exhumacion->motivo_rechazo ?? 'No se ha especificado un motivo de rechazo.' }}</p>
                        </div>
                    @endif

                    @if($exhumacion->estado_exhumacion == 'aprobada')
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Información importante:</strong>
                            <p class="mb-0">Su solicitud ha sido aprobada. Por favor acérquese a la municipalidad para coordinar los detalles del proceso.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de detalles del contrato -->
    <div class="modal fade" id="detallesContratoModal{{ $exhumacion->id_contrato }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-file-contract me-2"></i>Detalles del Contrato #{{ $exhumacion->id_contrato }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Contrato</h6>
                            <p><strong>ID Contrato:</strong> {{ $exhumacion->id_contrato }}</p>
                            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_inicio)->format('d/m/Y') }}</p>
                            <p><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_fin)->format('d/m/Y') }}</p>
                            <p><strong>Fecha Gracia:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_gracia)->format('d/m/Y') }}</p>
                            <p>
                                <strong>Estado Contrato:</strong> 
                                @if($exhumacion->estado_contrato == 'activo')
                                    <span class="badge bg-success">Activo</span>
                                @elseif($exhumacion->estado_contrato == 'vencido')
                                    <span class="badge bg-warning text-dark">Vencido</span>
                                @else
                                    <span class="badge bg-secondary">{{ $exhumacion->estado_contrato }}</span>
                                @endif
                            </p>
                            <p>
                                <strong>Estado Pago:</strong>
                                @if($exhumacion->estado_pago == 'pagado')
                                    <span class="badge bg-success">Pagado</span>
                                @elseif($exhumacion->estado_pago == 'pendiente_pago')
                                    <span class="badge bg-danger">Pendiente de Pago</span>
                                @else
                                    <span class="badge bg-secondary">{{ $exhumacion->estado_pago }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Nicho</h6>
                            <p><strong>ID Nicho:</strong> {{ $exhumacion->id_nicho }}</p>
                            <p><strong>Descripción:</strong> {{ $exhumacion->descripcion_nicho }}</p>
                            <p><strong>Tipo:</strong> {{ $exhumacion->tipo_nicho }}</p>
                            <p><strong>Ubicación:</strong> {{ $exhumacion->descripcion_ubicacion }}</p>
                            <p><strong>Calle:</strong> {{ $exhumacion->nombre_calle ?? 'N/A' }}</p>
                            <p><strong>Avenida:</strong> {{ $exhumacion->nombre_avenida ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Responsable</h6>
                            <p><strong>Nombre:</strong> {{ $exhumacion->nombre_responsable }} {{ $exhumacion->apellido_responsable }}</p>
                            <p><strong>DPI:</strong> {{ $exhumacion->dpi_responsable }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Ocupante</h6>
                            <p><strong>Nombre:</strong> {{ $exhumacion->nombre_ocupante }} {{ $exhumacion->apellido_ocupante }}</p>
                            <p><strong>Fecha Fallecimiento:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_fallecimiento)->format('d/m/Y') }}</p>
                            <p><strong>Causa:</strong> {{ $exhumacion->causa_muerte ?? 'No especificada' }}</p>
                            <p><strong>Tipo:</strong> {{ $exhumacion->tipo_ocupante }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection