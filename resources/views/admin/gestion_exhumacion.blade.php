@extends('layouts.admin')

@section('titulo', 'Gestión de Exhumaciones')

@section('titulo_seccion')
    <i class="fas fa-exchange-alt me-2"></i>Gestión de Exhumaciones
@endsection

@section('contenido')
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0"><i class="fas fa-list-alt me-2"></i>Exhumaciones Solicitadas</h5>
            </div>
            <div class="card-body">
                @if(count($exhumacionesPendientes) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Ocupante</th>
                                    <th>Responsable</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exhumacionesPendientes as $exhumacion)
                                <tr>
                                    <td>{{ $exhumacion->id_exhumacion }}</td>
                                    <td>{{ $exhumacion->nombre_ocupante }} {{ $exhumacion->apellido_ocupante }}</td>
                                    <td>{{ $exhumacion->nombre_responsable }} {{ $exhumacion->apellido_responsable }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exhumacion->fecha_exhumacion)->format('d/m/Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#motivoModal{{ $exhumacion->id_exhumacion }}">
                                            <i class="fas fa-eye"></i> Ver motivo
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.gestion_exhumacion.aceptar', $exhumacion->id_exhumacion) }}" class="btn btn-sm btn-success" onclick="return confirm('¿Está seguro de aceptar esta exhumación?')">
                                                <i class="fas fa-check"></i> Aceptar
                                            </a>
                                            <a href="{{ route('admin.gestion_exhumacion.rechazar', $exhumacion->id_exhumacion) }}" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de rechazar esta exhumación?')">
                                                <i class="fas fa-times"></i> Rechazar
                                            </a>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detalleModal{{ $exhumacion->id_exhumacion }}">
                                                <i class="fas fa-info-circle"></i> Detalles
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No hay solicitudes de exhumación pendientes en este momento.
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-admin">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Acciones</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.gestion_exhumacion.ver_exhumaciones') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>Ver Todas las Exhumaciones
                    </a>
                </div>
                <div class="mt-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title"><i class="fas fa-chart-pie me-2"></i>Resumen</h6>
                            <p class="mb-1">Exhumaciones pendientes: <span class="fw-bold">{{ count($exhumacionesPendientes) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales para mostrar información -->
@foreach($exhumacionesPendientes as $exhumacion)
    <!-- Modal para mostrar motivo -->
    <div class="modal fade" id="motivoModal{{ $exhumacion->id_exhumacion }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-comment-alt me-2"></i>Motivo de Exhumación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Motivo:</strong></p>
                    <div class="card">
                        <div class="card-body bg-light">
                            {{ $exhumacion->motivo }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar detalles completos -->
    <div class="modal fade" id="detalleModal{{ $exhumacion->id_exhumacion }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>Detalles de Exhumación #{{ $exhumacion->id_exhumacion }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="detailsTabs{{ $exhumacion->id_exhumacion }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="exhumacion-tab{{ $exhumacion->id_exhumacion }}" data-bs-toggle="tab" data-bs-target="#exhumacion{{ $exhumacion->id_exhumacion }}" type="button" role="tab">
                                Exhumación
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contrato-tab{{ $exhumacion->id_exhumacion }}" data-bs-toggle="tab" data-bs-target="#contrato{{ $exhumacion->id_exhumacion }}" type="button" role="tab">
                                Contrato
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ocupante-tab{{ $exhumacion->id_exhumacion }}" data-bs-toggle="tab" data-bs-target="#ocupante{{ $exhumacion->id_exhumacion }}" type="button" role="tab">
                                Ocupante/Nicho
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="detailsTabContent{{ $exhumacion->id_exhumacion }}">
                        <!-- Tab Exhumación -->
                        <div class="tab-pane fade show active" id="exhumacion{{ $exhumacion->id_exhumacion }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID Exhumación:</strong> {{ $exhumacion->id_exhumacion }}</p>
                                    <p><strong>Fecha de Solicitud:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_exhumacion)->format('d/m/Y') }}</p>
                                    <p><strong>Estado:</strong> 
                                        <span class="badge bg-warning">{{ ucfirst($exhumacion->estado_exhumacion) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Motivo:</strong></p>
                                    <div class="card">
                                        <div class="card-body bg-light">
                                            {{ $exhumacion->motivo }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab Contrato -->
                        <div class="tab-pane fade" id="contrato{{ $exhumacion->id_exhumacion }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID Contrato:</strong> {{ $exhumacion->id_contrato }}</p>
                                    <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_inicio)->format('d/m/Y') }}</p>
                                    <p><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_fin)->format('d/m/Y') }}</p>
                                    <p><strong>Fecha Gracia:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_gracia)->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Estado Contrato:</strong> 
                                        <span class="badge bg-{{ $exhumacion->estado_contrato == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($exhumacion->estado_contrato) }}
                                        </span>
                                    </p>
                                    <p><strong>Estado Pago:</strong> 
                                        <span class="badge bg-{{ $exhumacion->estado_pago == 'pagado' ? 'success' : 'warning' }}">
                                            {{ ucfirst($exhumacion->estado_pago) }}
                                        </span>
                                    </p>
                                    <p><strong>Usuario Generador:</strong> {{ $exhumacion->usuario_generador }}</p>
                                    <p><strong>Tipo Usuario:</strong> {{ $exhumacion->tipo_usuario }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab Ocupante/Nicho -->
                        <div class="tab-pane fade" id="ocupante{{ $exhumacion->id_exhumacion }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="border-bottom pb-2">Datos del Ocupante</h6>
                                    <p><strong>Nombre:</strong> {{ $exhumacion->nombre_ocupante }} {{ $exhumacion->apellido_ocupante }}</p>
                                    <p><strong>ID Ocupante:</strong> {{ $exhumacion->id_ocupante }}</p>
                                    <p><strong>Fallecimiento:</strong> {{ \Carbon\Carbon::parse($exhumacion->fecha_fallecimiento)->format('d/m/Y') }}</p>
                                    <p><strong>Causa:</strong> {{ $exhumacion->causa_muerte ?? 'No especificada' }}</p>
                                    <p><strong>Tipo:</strong> {{ $exhumacion->tipo_ocupante }}</p>
                                    
                                    <h6 class="border-bottom pb-2 mt-4">Datos del Responsable</h6>
                                    <p><strong>Nombre:</strong> {{ $exhumacion->nombre_responsable }} {{ $exhumacion->apellido_responsable }}</p>
                                    <p><strong>DPI:</strong> {{ $exhumacion->dpi_responsable }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="border-bottom pb-2">Datos del Nicho</h6>
                                    <p><strong>ID Nicho:</strong> {{ $exhumacion->id_nicho }}</p>
                                    <p><strong>Tipo:</strong> {{ $exhumacion->tipo_nicho }}</p>
                                    <p><strong>Estado:</strong> 
                                        <span class="badge bg-{{ $exhumacion->estado_nicho == 'ocupado' ? 'danger' : 'success' }}">
                                            {{ ucfirst($exhumacion->estado_nicho) }}
                                        </span>
                                    </p>
                                    <p><strong>Descripción:</strong> {{ $exhumacion->descripcion_nicho }}</p>
                                    
                                    <h6 class="border-bottom pb-2 mt-4">Ubicación</h6>
                                    <p><strong>Ubicación:</strong> {{ $exhumacion->descripcion_ubicacion }}</p>
                                    <p><strong>Calle:</strong> {{ $exhumacion->nombre_calle }}</p>
                                    <p><strong>Avenida:</strong> {{ $exhumacion->nombre_avenida }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <div class="btn-group">
                        <a href="{{ route('admin.gestion_exhumacion.aceptar', $exhumacion->id_exhumacion) }}" class="btn btn-success" onclick="return confirm('¿Está seguro de aceptar esta exhumación?')">
                            <i class="fas fa-check me-1"></i>Aceptar
                        </a>
                        <a href="{{ route('admin.gestion_exhumacion.rechazar', $exhumacion->id_exhumacion) }}" class="btn btn-danger" onclick="return confirm('¿Está seguro de rechazar esta exhumación?')">
                            <i class="fas fa-times me-1"></i>Rechazar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('scripts')
<script>
    // Activar los tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection