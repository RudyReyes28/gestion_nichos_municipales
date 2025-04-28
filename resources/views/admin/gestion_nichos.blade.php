<!-- resources/views/admin/gestion_nichos.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Gestión de Nichos')

@section('titulo_seccion', 'Gestión de Nichos')

@section('contenido')
<div class="row mb-4">
    <div class="col-md-6">
        <h4><i class="fas fa-monument me-2"></i>Nichos Registrados</h4>
    </div>
    <div class="col-md-6 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarNicho">
            <i class="fas fa-plus me-2"></i>Agregar Nicho
        </button>
    </div>
</div>

<div class="card card-admin">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Ubicación</th>
                        <th>Avenida</th>
                        <th>Calle</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nichos as $nicho)
                    <tr>
                        <td>{{ $nicho->id_nicho }}</td>
                        <td>{{ $nicho->tipo_nicho }}</td>
                        <td>{{ $nicho->descripcion_ubicacion }}</td>
                        <td>{{ $nicho->nombre_avenida }}</td>
                        <td>{{ $nicho->nombre_calle }}</td>
                        <td>
                            @if($nicho->estado == 'disponible')
                                <span class="badge bg-success">Disponible</span>
                            @elseif($nicho->estado == 'ocupado')
                                <span class="badge bg-danger">Ocupado</span>
                            @elseif($nicho->estado == 'reservado')
                                <span class="badge bg-warning text-dark">Reservado</span>
                            @else
                                <span class="badge bg-secondary">{{ $nicho->estado }}</span>
                            @endif
                        </td>
                        <td>{{ $nicho->descripcion_nicho }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" title="Ver detalles" data-bs-toggle="modal" data-bs-target="#modalVerNicho{{ $nicho->id_nicho }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay nichos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para agregar nicho -->
<div class="modal fade" id="modalAgregarNicho" tabindex="-1" aria-labelledby="modalAgregarNichoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAgregarNichoLabel"><i class="fas fa-plus-circle me-2"></i>Agregar Nuevo Nicho</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.gestion_nichos.crear_nicho') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_nicho" class="form-label">Tipo de Nicho</label>
                                <select class="form-select" id="tipo_nicho" name="tipo_nicho" required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tipos_nicho as $tipo)
                                        <option value="{{ $tipo->id_tipo_nicho }}">{{ $tipo->nombre_tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_nicho" class="form-label">Descripción del Nicho</label>
                                <input type="text" class="form-control" id="descripcion_nicho" name="descripcion_nicho" placeholder="Descripción detallada" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_avenida" class="form-label">Avenida</label>
                                <input type="text" class="form-control" id="nombre_avenida" name="nombre_avenida" placeholder="Nombre de la avenida" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_calle" class="form-label">Calle</label>
                                <input type="text" class="form-control" id="nombre_calle" name="nombre_calle" placeholder="Nombre de la calle" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion_ubicacion" class="form-label">Descripcion Ubicación</label>
                                <input type="text" class="form-control" id="descripcion_ubicacion" name="descripcion_ubicacion" placeholder="Descripcion de la ubicacion" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar Nicho</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales para ver detalles de cada nicho -->
@foreach($nichos as $nicho)
<div class="modal fade" id="modalVerNicho{{ $nicho->id_nicho }}" tabindex="-1" aria-labelledby="modalVerNichoLabel{{ $nicho->id_nicho }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalVerNichoLabel{{ $nicho->id_nicho }}"><i class="fas fa-monument me-2"></i>Detalles del Nicho #{{ $nicho->id_nicho }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $nicho->id_nicho }}</p>
                        <p><strong>Tipo:</strong> {{ $nicho->tipo_nicho }}</p>
                        <p><strong>Estado:</strong> 
                            @if($nicho->estado == 'disponible')
                                <span class="badge bg-success">Disponible</span>
                            @elseif($nicho->estado == 'ocupado')
                                <span class="badge bg-danger">Ocupado</span>
                            @elseif($nicho->estado == 'reservado')
                                <span class="badge bg-warning text-dark">Reservado</span>
                            @else
                                <span class="badge bg-secondary">{{ $nicho->estado }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Avenida:</strong> {{ $nicho->nombre_avenida }}</p>
                        <p><strong>Calle:</strong> {{ $nicho->nombre_calle }}</p>
                        <p><strong>Ubicación:</strong> {{ $nicho->descripcion_ubicacion }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Descripción:</strong> {{ $nicho->descripcion_nicho }}</p>
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
    // Script para mantener abiertos los modales cuando hay errores de validación
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            const modal = new bootstrap.Modal(document.getElementById('modalAgregarNicho'));
            modal.show();
        @endif
    });
</script>
@endsection