@extends('layouts.usuario')

@section('titulo', 'Mis Nichos')

@section('titulo_seccion', 'Mis Nichos')

@section('contenido')
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-monument me-2"></i>Información de mis nichos contratados</h5>
    </div>
    <div class="card-body">
        @if(count($informacion) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Nicho</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Ocupante</th>
                            <th>Estado Contrato</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informacion as $nicho)
                        <tr>
                            <td>{{ $nicho->id_nicho }}</td>
                            <td>{{ $nicho->descripcion_nicho }}</td>
                            <td>{{ $nicho->tipo_nicho }}</td>
                            <td>
                                <span class="d-block">{{ $nicho->descripcion_ubicacion }}</span>
                                <small class="text-muted">Calle: {{ $nicho->nombre_calle ?? 'No especificada' }} - Avenida: {{ $nicho->nombre_avenida ?? 'No especificada' }}</small>
                            </td>
                            <td>{{ $nicho->nombre_ocupante }} {{ $nicho->apellido_ocupante }}</td>
                            <td>
                                @if($nicho->estado_contrato == 'activo')
                                    <span class="badge bg-success">Activo</span>
                                @elseif($nicho->estado_contrato == 'vencido')
                                    <span class="badge bg-danger">Vencido</span>
                                @elseif($nicho->estado_contrato == 'pendiente_pago')
                                    <span class="badge bg-warning text-dark">Pendiente de pago</span>
                                @else
                                    <span class="badge bg-secondary">{{ $nicho->estado_contrato }}</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#ocupanteModal{{ $nicho->id_ocupante }}">
                                    <i class="fas fa-user me-1"></i> Detalles Ocupante
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No tienes nichos contratados actualmente.
                <a href="{{ route('usuario.nichos') }}" class="alert-link">Consulta nichos disponibles aquí</a>.
            </div>
        @endif
    </div>
</div>

<!-- Modales para detalles de ocupantes -->
@foreach($informacion as $nicho)
<div class="modal fade" id="ocupanteModal{{ $nicho->id_ocupante }}" tabindex="-1" aria-labelledby="ocupanteModalLabel{{ $nicho->id_ocupante }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="ocupanteModalLabel{{ $nicho->id_ocupante }}">
                    <i class="fas fa-user me-2"></i>Detalles del Ocupante
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-3 text-muted">Información Personal</h6>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Nombre completo:</div>
                            <div class="col-sm-8">{{ $nicho->nombre_ocupante }} {{ $nicho->apellido_ocupante }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Tipo de ocupante:</div>
                            <div class="col-sm-8">{{ $nicho->tipo_ocupante }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Fecha fallecimiento:</div>
                            <div class="col-sm-8">{{ $nicho->fecha_fallecimiento }}</div>
                        </div>

                        @if($nicho->causa_muerte)
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Causa de fallecimiento:</div>
                            <div class="col-sm-8">{{ $nicho->causa_muerte }}</div>
                        </div>
                        @endif

                        <h6 class="card-subtitle mt-4 mb-3 text-muted">Información del Nicho</h6>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">ID Nicho:</div>
                            <div class="col-sm-8">{{ $nicho->id_nicho }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Descripción:</div>
                            <div class="col-sm-8">{{ $nicho->descripcion_nicho }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Ubicación:</div>
                            <div class="col-sm-8">{{ $nicho->descripcion_ubicacion }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Calle / Avenida:</div>
                            <div class="col-sm-8">{{ $nicho->nombre_calle ?? 'No especificada' }} / {{ $nicho->nombre_avenida ?? 'No especificada' }}</div>
                        </div>
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

@section('scripts')
<script>
    // Script para cerrar automáticamente las alertas después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alertList = document.querySelectorAll('.alert');
            alertList.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection