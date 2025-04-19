@extends('layouts.usuario')

@section('titulo', 'Mis Contratos')

@section('titulo_seccion', 'Mis Contratos')

@section('contenido')



    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-file-contract me-2"></i>Información de mis contratos</h5>
        </div>
        <div class="card-body">
            @if(count($servicioContratos) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID Contrato</th>
                                <th>Nicho</th>
                                <th>Ocupante</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado Contrato</th>
                                <th>Estado Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicioContratos as $contrato)
                            <tr>
                                <td>{{ $contrato->id_contrato }}</td>
                                <td>
                                    <span class="d-block">{{ $contrato->id_nicho }}</span>
                                    <small class="text-muted">{{ $contrato->descripcion_nicho }}</small>
                                </td>
                                <td>{{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</td>
                                <td>{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</td>
                                <td>
                                    @if($contrato->estado_contrato == 'activo')
                                        <span class="badge bg-success">Activo</span>
                                    @elseif($contrato->estado_contrato == 'vencido')
                                        <span class="badge bg-danger">Vencido</span>
                                    @elseif($contrato->estado_contrato == 'pendiente_pago')
                                        <span class="badge bg-warning text-dark">Pendiente de pago</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($contrato->estado_pago == 'pagado')
                                        <span class="badge bg-success">Pagado</span>
                                    @elseif($contrato->estado_pago == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contrato->estado_pago }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#contratoModal{{ $contrato->id_contrato }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>

                                        @php
            $boleta = collect($boletas)->firstWhere('id_contrato', $contrato->id_contrato);
                                        @endphp

                                        @if($boleta)
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#boletaModal{{ $boleta->id_boleta }}">
                                            <i class="fas fa-receipt"></i>
                                        </button>

                                        @if($contrato->estado_pago == 'pendiente' || $contrato->estado_contrato == 'pago_pendiente')
                                        <a href="{{ route('usuario.pagar_boleta', ['id_boleta' => $boleta->id_boleta]) }}" class="btn btn-sm btn-success" onclick="return confirm('¿Está seguro que desea realizar este pago?')">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </a>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No tienes contratos actualmente.
                    <a href="{{ route('usuario.nichos') }}" class="alert-link">Consulta nichos disponibles aquí</a>.
                </div>
            @endif
        </div>
    </div>

    <!-- Modales para detalles de contratos -->
    @foreach($servicioContratos as $contrato)
    <div class="modal fade" id="contratoModal{{ $contrato->id_contrato }}" tabindex="-1" aria-labelledby="contratoModalLabel{{ $contrato->id_contrato }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="contratoModalLabel{{ $contrato->id_contrato }}">
                        <i class="fas fa-file-contract me-2"></i>Detalles del Contrato #{{ $contrato->id_contrato }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Contrato</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">ID Contrato:</div>
                                        <div class="col-sm-7">{{ $contrato->id_contrato }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Fecha Inicio:</div>
                                        <div class="col-sm-7">{{ \Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Fecha Fin:</div>
                                        <div class="col-sm-7">{{ \Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Fecha Gracia:</div>
                                        <div class="col-sm-7">{{ \Carbon\Carbon::parse($contrato->fecha_gracia)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Estado Contrato:</div>
                                        <div class="col-sm-7">
                                            @if($contrato->estado_contrato == 'activo')
                                                <span class="badge bg-success">Activo</span>
                                            @elseif($contrato->estado_contrato == 'vencido')
                                                <span class="badge bg-danger">Vencido</span>
                                            @elseif($contrato->estado_contrato == 'pendiente_pago')
                                                <span class="badge bg-warning text-dark">Pendiente de pago</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Estado Pago:</div>
                                        <div class="col-sm-7">
                                            @if($contrato->estado_pago == 'pagado')
                                                <span class="badge bg-success">Pagado</span>
                                            @elseif($contrato->estado_pago == 'pendiente')
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $contrato->estado_pago }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Usuario Generador:</div>
                                        <div class="col-sm-7">{{ $contrato->usuario_generador }} ({{ $contrato->tipo_usuario }})</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Nicho</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">ID Nicho:</div>
                                        <div class="col-sm-7">{{ $contrato->id_nicho }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Descripción:</div>
                                        <div class="col-sm-7">{{ $contrato->descripcion_nicho }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Estado:</div>
                                        <div class="col-sm-7">{{ $contrato->estado_nicho }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Tipo:</div>
                                        <div class="col-sm-7">{{ $contrato->tipo_nicho }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Ubicación:</div>
                                        <div class="col-sm-7">{{ $contrato->descripcion_ubicacion }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Calle / Avenida:</div>
                                        <div class="col-sm-7">{{ $contrato->nombre_calle ?? 'No especificada' }} / {{ $contrato->nombre_avenida ?? 'No especificada' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Responsable</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Nombre:</div>
                                        <div class="col-sm-7">{{ $contrato->nombre_responsable }} {{ $contrato->apellido_responsable }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">DPI:</div>
                                        <div class="col-sm-7">{{ $contrato->dpi_responsable }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Información del Ocupante</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Nombre:</div>
                                        <div class="col-sm-7">{{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Tipo:</div>
                                        <div class="col-sm-7">{{ $contrato->tipo_ocupante }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Fecha Fallecimiento:</div>
                                        <div class="col-sm-7">{{ $contrato->fecha_fallecimiento }}</div>
                                    </div>
                                    @if($contrato->causa_muerte)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 text-muted">Causa:</div>
                                        <div class="col-sm-7">{{ $contrato->causa_muerte }}</div>
                                    </div>
                                    @endif
                                </div>
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

    <!-- Modales para boletas -->
    @foreach($boletas as $boleta)
        <div class="modal fade" id="boletaModal{{ $boleta->id_boleta }}" tabindex="-1" aria-labelledby="boletaModalLabel{{ $boleta->id_boleta }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="boletaModalLabel{{ $boleta->id_boleta }}">
                            <i class="fas fa-receipt me-2"></i>Boleta de Pago #{{ $boleta->id_boleta }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-muted">ID Boleta:</div>
                                    <div class="col-sm-7">{{ $boleta->id_boleta }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-muted">ID Contrato:</div>
                                    <div class="col-sm-7">{{ $boleta->id_contrato }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-muted">Total:</div>
                                    <div class="col-sm-7">Q. {{ number_format($boleta->total, 2) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-muted">Estado:</div>
                                    <div class="col-sm-7">
                                        @if($boleta->estado == 'pagado')
                                            <span class="badge bg-success">Pagado</span>
                                        @elseif($boleta->estado == 'pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $boleta->estado }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-muted">Fecha Emisión:</div>
                                    <div class="col-sm-7">{{ \Carbon\Carbon::parse($boleta->fecha_emision)->format('d/m/Y') }}</div>
                                </div>
                                @if($boleta->ruta_comprobante)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="text-muted">Comprobante de Pago:</label>
                                            <div class="mt-2 text-center">
                                                <img src="{{ $boleta->ruta_comprobante }}" alt="Comprobante de pago" class="img-fluid border"
                                                    style="max-height: 500px; width: auto; cursor: pointer;" onclick="openFullImage(this.src)"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Click para ampliar">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($boleta->estado == 'pago_pendiente')
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <a href="{{ route('usuario.pagar_boleta', ['id_boleta' => $boleta->id_boleta]) }}" class="btn btn-success" onclick="return confirm('¿Está seguro que desea realizar este pago?')">
                                            <i class="fas fa-money-bill-wave me-2"></i>Realizar Pago
                                        </a>
                                    </div>
                                </div>
                                @endif
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
        
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    // Función para abrir imagen en pantalla completa
    function openFullImage(src) {
    // Crear un modal para la imagen si no existe
    var modalElement = document.getElementById('imageFullscreenModal') || createImageModal();
    var imageModal = new bootstrap.Modal(modalElement);
    
    // Establecer la imagen en el modal
    var imgElement = document.getElementById('fullscreenImage');
    imgElement.src = src;
    
    // Resetear el zoom al abrir
    imgElement.style.transform = 'scale(1)';
    currentZoom = 1;
    
    // Mostrar el modal
    imageModal.show();
}

// Variables para control de zoom
var currentZoom = 1;
const zoomStep = 0.25;
const maxZoom = 3;
const minZoom = 0.5;

// Función para crear el modal de imagen si no existe
function createImageModal() {
    // Crear el elemento modal
    var modalDiv = document.createElement('div');
    modalDiv.className = 'modal fade';
    modalDiv.id = 'imageFullscreenModal';
    modalDiv.tabIndex = '-1';
    modalDiv.setAttribute('aria-hidden', 'true');
    
    // Contenido del modal
    modalDiv.innerHTML = `
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0 text-white">
                    <div class="zoom-controls">
                        <button type="button" class="btn btn-outline-light btn-sm me-2" onclick="zoomImage('out')">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <span id="zoomPercentage" class="text-light">100%</span>
                        <button type="button" class="btn btn-outline-light btn-sm ms-2" onclick="zoomImage('in')">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-0">
                    <div class="image-container overflow-auto" style="max-height: 80vh;">
                        <img id="fullscreenImage" class="img-fluid" style="transition: transform 0.3s ease;" src="" alt="Comprobante de pago">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Añadir el modal al body
    document.body.appendChild(modalDiv);
    
    return modalDiv;
}

// Función para aplicar zoom a la imagen
function zoomImage(direction) {
    const imgElement = document.getElementById('fullscreenImage');
    const zoomPercentage = document.getElementById('zoomPercentage');
    
    if (direction === 'in' && currentZoom < maxZoom) {
        currentZoom += zoomStep;
    } else if (direction === 'out' && currentZoom > minZoom) {
        currentZoom -= zoomStep;
    }
    
    // Aplicar el nuevo zoom
    imgElement.style.transform = `scale(${currentZoom})`;
    
    // Actualizar el indicador de porcentaje
    zoomPercentage.textContent = Math.round(currentZoom * 100) + '%';
}

</script>
@endsection