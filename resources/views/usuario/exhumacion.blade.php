<!-- resources/views/usuario/exhumacion.blade.php -->
@extends('layouts.usuario')

@section('titulo', 'Exhumaciones')

@section('titulo_seccion', 'Gestión de Exhumaciones')

@section('contenido')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Contratos disponibles para exhumación</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0">Seleccione un contrato para solicitar una exhumación.</p>
                <a href="{{ route('usuario.mis_exhumaciones') }}" class="btn btn-primary">
                    <i class="fas fa-list me-1"></i> Ver mis exhumaciones
                </a>
            </div>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Nota importante:</strong> Los ocupantes catalogados como "Personaje Histórico" no pueden ser exhumados por regulaciones municipales.
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Contrato</th>
                        <th>Ocupante</th>
                        <th>Tipo</th>
                        <th>Ubicación del Nicho</th>
                        <th>Fecha Fallecimiento</th>
                        <th>Estado Contrato</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($misContratos) > 0)
                        @foreach($misContratos as $contrato)
                            <tr class="{{ $contrato->tipo_ocupante == 'Personaje Historico' ? 'table-secondary' : '' }}">
                                <td>#{{ $contrato->id_contrato }}</td>
                                <td>{{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</td>
                                <td>
                                    @if($contrato->tipo_ocupante == 'Personaje Historico')
                                        <span class="badge bg-dark">Personaje Histórico</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->tipo_ocupante }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $contrato->descripcion_nicho }}</span><br>
                                    <small>Calle: {{ $contrato->nombre_calle ?? 'N/A' }}, Ave: {{ $contrato->nombre_avenida ?? 'N/A' }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($contrato->fecha_fallecimiento)->format('d/m/Y') }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @elseif($contrato->estado_contrato == 'vencido')
                                        <span class="badge bg-warning text-dark">Vencido</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($contrato->tipo_ocupante == 'Personaje Historico')
                                        <button type="button" class="btn btn-sm btn-danger mb-1" disabled title="No se permite la exhumación de Personajes Históricos">
                                            <i class="fas fa-ban"></i> Exhumación no permitida
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#exhumacionModal{{ $contrato->id_contrato }}">
                                            <i class="fas fa-exchange-alt"></i> Solicitar Exhumación
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="modal" data-bs-target="#detallesModal{{ $contrato->id_contrato }}">
                                        <i class="fas fa-info-circle"></i> Ver Detalles
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No tiene contratos disponibles para exhumación</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modales para cada contrato -->
@foreach($misContratos as $contrato)
    @if($contrato->tipo_ocupante != 'Personaje Historico')
        <!-- Modal para solicitar exhumación (solo para los que no son Personaje Histórico) -->
        <div class="modal fade" id="exhumacionModal{{ $contrato->id_contrato }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exchange-alt me-2"></i>Solicitar Exhumación
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('usuario.registrar_exhumacion') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id_contrato" value="{{ $contrato->id_contrato }}">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Datos del Ocupante:</label>
                                <p class="mb-1">{{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</p>
                                <p class="mb-1">Fecha de fallecimiento: {{ \Carbon\Carbon::parse($contrato->fecha_fallecimiento)->format('d/m/Y') }}</p>
                                <p class="mb-1">Causa: {{ $contrato->causa_muerte ?? 'No especificada' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="fecha_exhumacion" class="form-label">Fecha de Exhumación:</label>
                                <input type="date" class="form-control" id="fecha_exhumacion" name="fecha_exhumacion" required>
                                <div class="form-text">Seleccione la fecha en que desea realizar la exhumación</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="motivo" class="form-label">Motivo de la Exhumación:</label>
                                <textarea class="form-control" id="motivo" name="motivo" rows="4" required placeholder="Describa detalladamente el motivo de la exhumación..."></textarea>
                            </div>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <small>Al solicitar una exhumación, deberá cumplir con todos los requisitos legales y sanitarios establecidos por la municipalidad. Un administrador revisará su solicitud.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal para ver detalles del contrato (para todos) -->
    <div class="modal fade" id="detallesModal{{ $contrato->id_contrato }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>Detalles del Contrato #{{ $contrato->id_contrato }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($contrato->tipo_ocupante == 'Personaje Historico')
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Restricción:</strong> Este ocupante está catalogado como Personaje Histórico y no puede ser exhumado según las regulaciones municipales.
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Contrato</h6>
                            <p><strong>ID Contrato:</strong> {{ $contrato->id_contrato }}</p>
                            <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</p>
                            <p><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</p>
                            <p><strong>Fecha Gracia:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_gracia)->format('d/m/Y') }}</p>
                            <p>
                                <strong>Estado Contrato:</strong> 
                                @if($contrato->estado_contrato == 'activo')
                                    <span class="badge bg-success">Activo</span>
                                @elseif($contrato->estado_contrato == 'vencido')
                                    <span class="badge bg-warning text-dark">Vencido</span>
                                @else
                                    <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
                                @endif
                            </p>
                            <p>
                                <strong>Estado Pago:</strong>
                                @if($contrato->estado_pago == 'pagado')
                                    <span class="badge bg-success">Pagado</span>
                                @elseif($contrato->estado_pago == 'pendiente_pago')
                                    <span class="badge bg-danger">Pendiente de Pago</span>
                                @else
                                    <span class="badge bg-secondary">{{ $contrato->estado_pago }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Nicho</h6>
                            <p><strong>ID Nicho:</strong> {{ $contrato->id_nicho }}</p>
                            <p><strong>Descripción:</strong> {{ $contrato->descripcion_nicho }}</p>
                            <p><strong>Tipo:</strong> {{ $contrato->tipo_nicho }}</p>
                            <p><strong>Ubicación:</strong> {{ $contrato->descripcion_ubicacion }}</p>
                            <p><strong>Calle:</strong> {{ $contrato->nombre_calle ?? 'N/A' }}</p>
                            <p><strong>Avenida:</strong> {{ $contrato->nombre_avenida ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Responsable</h6>
                            <p><strong>Nombre:</strong> {{ $contrato->nombre_responsable }} {{ $contrato->apellido_responsable }}</p>
                            <p><strong>DPI:</strong> {{ $contrato->dpi_responsable }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Ocupante</h6>
                            <p><strong>Nombre:</strong> {{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</p>
                            <p><strong>Fecha Fallecimiento:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_fallecimiento)->format('d/m/Y') }}</p>
                            <p><strong>Causa:</strong> {{ $contrato->causa_muerte ?? 'No especificada' }}</p>
                            <p>
                                <strong>Tipo:</strong> 
                                @if($contrato->tipo_ocupante == 'Personaje Historico')
                                    <span class="badge bg-dark">{{ $contrato->tipo_ocupante }}</span>
                                @else
                                    {{ $contrato->tipo_ocupante }}
                                @endif
                            </p>
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
        // Establecer fecha mínima para el campo de fecha de exhumación (hoy + 3 días)
        const fechaInputs = document.querySelectorAll('input[name="fecha_exhumacion"]');
        
        if (fechaInputs.length > 0) {
            const hoy = new Date();
            const minDate = new Date();
            minDate.setDate(hoy.getDate() + 3); // Mínimo 3 días después
            
            const formatDate = date => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            fechaInputs.forEach(input => {
                input.setAttribute('min', formatDate(minDate));
            });
        }
    });
</script>
@endsection