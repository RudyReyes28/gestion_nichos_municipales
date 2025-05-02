<!-- resources/views/auditoria/auditar.blade.php -->
@extends('layouts.auditoria')

@section('titulo', 'Realizar Auditoría')

@section('estilos')
<style>
    .badge-pendiente {
        background-color: #FFC107;
        color: #212529;
    }
    .badge-completada {
        background-color: #28A745;
        color: white;
    }
    .badge-rechazada {
        background-color: #DC3545;
        color: white;
    }
    .modal-audit {
        border-left: 4px solid #3e6b89;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('titulo_seccion')
    <i class="fas fa-tasks me-2"></i>Realizar Auditoría
@endsection

@section('contenido')
    <div class="row">
        <!-- Mis Auditorías -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Mis Auditorías</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaAuditoriaModal">
                            <i class="fas fa-plus me-1"></i> Nueva Auditoría
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Contrato</th>
                                    <th>Nicho</th>
                                    <th>Tipo Problema</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($auditorias as $auditoria)
                                <tr>
                                    <td>{{ $auditoria->id_auditoria }}</td>
                                    <td>{{ \Carbon\Carbon::parse($auditoria->fecha_hora)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $auditoria->id_contrato }}</td>
                                    <td>{{ $auditoria->descripcion_nicho }}</td>
                                    <td>{{ $auditoria->tipo_problema }}</td>
                                    <td>
                                        @if($auditoria->estado == 'pendiente')
                                            <span class="badge badge-pendiente">Pendiente</span>
                                        @elseif($auditoria->estado == 'completada')
                                            <span class="badge badge-completada">Completada</span>
                                        @elseif($auditoria->estado == 'rechazada')
                                            <span class="badge badge-rechazada">Rechazada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#verAuditoriaModal{{ $auditoria->id_auditoria }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay auditorías registradas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear nueva auditoría -->
    <div class="modal fade" id="nuevaAuditoriaModal" tabindex="-1" aria-labelledby="nuevaAuditoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-audit">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="nuevaAuditoriaModalLabel">Nueva Auditoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('auditoria.auditar.crear_auditoria') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_contrato" class="form-label">Contrato a Auditar</label>
                            <select class="form-select" id="id_contrato" name="id_contrato" required>
                                <option value="">Seleccione un contrato</option>
                                @foreach($contratos as $contrato)
                                <option value="{{ $contrato->id_contrato }}">
                                    #{{ $contrato->id_contrato }} - {{ $contrato->descripcion_nicho }} - {{ $contrato->nombre_responsable }} {{ $contrato->apellido_responsable }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_problema" class="form-label">Tipo de Problema</label>
                            <select class="form-select" id="tipo_problema" name="tipo_problema" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Documentación incompleta">Documentación incompleta</option>
                                <option value="Pago pendiente">Pago pendiente</option>
                                <option value="Estado del nicho">Estado del nicho</option>
                                <option value="Información incorrecta">Información incorrecta</option>
                                <option value="Vencimiento de contrato">Vencimiento de contrato</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="detalles_auditoria" class="form-label">Detalles de la Auditoría</label>
                            <textarea class="form-control" id="detalles_auditoria" name="detalles_auditoria" rows="5" placeholder="Describa los detalles del problema encontrado..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Auditoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para ver detalles de cada auditoría -->
    @foreach($auditorias as $auditoria)
    <div class="modal fade" id="verAuditoriaModal{{ $auditoria->id_auditoria }}" tabindex="-1" aria-labelledby="verAuditoriaModalLabel{{ $auditoria->id_auditoria }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-audit">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="verAuditoriaModalLabel{{ $auditoria->id_auditoria }}">Detalles de Auditoría #{{ $auditoria->id_auditoria }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Fecha de Auditoría:</strong> {{ \Carbon\Carbon::parse($auditoria->fecha_hora)->format('d/m/Y H:i') }}</p>
                            <p><strong>Contrato:</strong> #{{ $auditoria->id_contrato }}</p>
                            <p><strong>Nicho:</strong> {{ $auditoria->descripcion_nicho }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tipo de Problema:</strong> {{ $auditoria->tipo_problema }}</p>
                            <p><strong>Estado:</strong> 
                                @if($auditoria->estado == 'pendiente')
                                    <span class="badge badge-pendiente">Pendiente</span>
                                @elseif($auditoria->estado == 'completada')
                                    <span class="badge badge-completada">Completada</span>
                                @elseif($auditoria->estado == 'rechazada')
                                    <span class="badge badge-rechazada">Rechazada</span>
                                @endif
                            </p>
                            <p><strong>Auditor:</strong> {{ $auditoria->auditor_nombre }} {{ $auditoria->auditor_apellido }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Detalles:</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $auditoria->detalles_auditoria }}</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Resaltar filas al pasar el mouse
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection