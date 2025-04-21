@extends('layouts.admin')

@section('titulo', 'Gestión de Boletas')

@section('titulo_seccion')
    <i class="fas fa-receipt me-2"></i> Gestión de Boletas de Pago
@endsection

@section('estilos')
<style>
    .badge-pago-pendiente {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-pago-realizado {
        background-color: #17a2b8;
        color: #fff;
    }
    .badge-pagado {
        background-color: #28a745;
        color: #fff;
    }
    .modal-img {
        max-width: 100%;
        max-height: 80vh;
    }
    .btn-ver-detalles {
        background-color: #3e6b89;
        color: white;
    }
    .btn-ver-detalles:hover {
        background-color: #2c4d63;
        color: white;
    }
    .table th {
        background-color: #eef2f5;
    }
</style>
@endsection

@section('contenido')
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Boletas de Pago</h5>
            <div>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary" id="filtroTodos">
                        Todos
                    </button>
                    <button type="button" class="btn btn-outline-warning" id="filtroPendiente">
                        Pendientes
                    </button>
                    <button type="button" class="btn btn-outline-info" id="filtroRealizado">
                        Realizados
                    </button>
                    <button type="button" class="btn btn-outline-success" id="filtroPagado">
                        Pagados
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID Boleta</th>
                            <th scope="col">Fecha Emisión</th>
                            <th scope="col">Contrato</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Ocupante</th>
                            <th scope="col">Total</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($boletas as $boleta)
                            <tr class="fila-boleta" data-estado="{{ $boleta->estado_boleta }}">
                                <td>{{ $boleta->id_boleta }}</td>
                                <td>{{ date('d/m/Y', strtotime($boleta->fecha_emision)) }}</td>
                                <td>{{ $boleta->id_contrato }}</td>
                                <td>{{ $boleta->nombre_responsable }} {{ $boleta->apellido_responsable }}</td>
                                <td>{{ $boleta->nombre_ocupante }} {{ $boleta->apellido_ocupante }}</td>
                                <td>Q. {{ number_format($boleta->total, 2) }}</td>
                                <td>
                                    @if($boleta->estado_boleta == 'pago_pendiente')
                                        <span class="badge rounded-pill badge-pago-pendiente">Pendiente</span>
                                    @elseif($boleta->estado_boleta == 'pago_realizado')
                                        <span class="badge rounded-pill badge-pago-realizado">Realizado</span>
                                    @elseif($boleta->estado_boleta == 'pagado')
                                        <span class="badge rounded-pill badge-pagado">Pagado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-ver-detalles" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetallesContrato"
                                                data-boleta="{{ json_encode($boleta) }}">
                                            <i class="fas fa-eye"></i> Detalles
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalVerComprobante"
                                                data-ruta="{{ $boleta->ruta_comprobante }}"
                                                data-id="{{ $boleta->id_boleta }}">
                                            <i class="fas fa-file-image"></i> Comprobante
                                        </button>
                                        
                                        @if($boleta->estado_boleta == 'pago_realizado')
                                            <a href="{{ route('admin.boleta_pago.aceptar_pago', $boleta->id_boleta) }}" 
                                               class="btn btn-sm btn-success" 
                                               onclick="return confirm('¿Está seguro de marcar esta boleta como pagada?')">
                                                <i class="fas fa-check"></i> Marcar como Pagado
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay boletas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detalles Contrato -->
    <div class="modal fade" id="modalDetallesContrato" tabindex="-1" aria-labelledby="modalDetallesContratoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalDetallesContratoLabel">Detalles del Contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Contrato</h6>
                            <p><strong>ID Contrato:</strong> <span id="id-contrato"></span></p>
                            <p><strong>Fecha Inicio:</strong> <span id="fecha-inicio"></span></p>
                            <p><strong>Fecha Fin:</strong> <span id="fecha-fin"></span></p>
                            <p><strong>Fecha Gracia:</strong> <span id="fecha-gracia"></span></p>
                            <p><strong>Estado Contrato:</strong> <span id="estado-contrato"></span></p>
                            <p><strong>Estado Pago:</strong> <span id="estado-pago"></span></p>
                            <p><strong>Usuario Generador:</strong> <span id="usuario-generador"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Información del Responsable</h6>
                            <p><strong>Nombre:</strong> <span id="nombre-responsable"></span></p>
                            <p><strong>DPI:</strong> <span id="dpi-responsable"></span></p>
                            
                            <h6 class="border-bottom pb-2 mb-3 mt-4">Información del Ocupante</h6>
                            <p><strong>Nombre:</strong> <span id="nombre-ocupante"></span></p>
                            <p><strong>Fecha Fallecimiento:</strong> <span id="fecha-fallecimiento"></span></p>
                            <p><strong>Causa Muerte:</strong> <span id="causa-muerte"></span></p>
                            <p><strong>Tipo Ocupante:</strong> <span id="tipo-ocupante"></span></p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Información del Nicho</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID Nicho:</strong> <span id="id-nicho"></span></p>
                                    <p><strong>Descripción:</strong> <span id="descripcion-nicho"></span></p>
                                    <p><strong>Estado:</strong> <span id="estado-nicho"></span></p>
                                    <p><strong>Tipo:</strong> <span id="tipo-nicho"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Ubicación:</strong> <span id="descripcion-ubicacion"></span></p>
                                    <p><strong>Calle:</strong> <span id="nombre-calle"></span></p>
                                    <p><strong>Avenida:</strong> <span id="nombre-avenida"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Información de Boleta</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID Boleta:</strong> <span id="id-boleta"></span></p>
                                    <p><strong>Total:</strong> <span id="total-boleta"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Estado:</strong> <span id="estado-boleta"></span></p>
                                    <p><strong>Fecha Emisión:</strong> <span id="fecha-emision"></span></p>
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

    <!-- Modal Ver Comprobante -->
    <div class="modal fade" id="modalVerComprobante" tabindex="-1" aria-labelledby="modalVerComprobanteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalVerComprobanteLabel">Comprobante de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="img-comprobante" src="{{ $boleta->ruta_comprobante }}" alt="Comprobante de pago" class="modal-img img-fluid"
                    style="cursor: pointer;"
                    onclick="openFullImage(this.src)"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Click para ampliar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal detalles contrato
        var modalDetallesContrato = document.getElementById('modalDetallesContrato');
        modalDetallesContrato.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var boleta = JSON.parse(button.getAttribute('data-boleta'));
            
            // Información del Contrato
            document.getElementById('id-contrato').textContent = boleta.id_contrato;
            document.getElementById('fecha-inicio').textContent = formatDate(boleta.fecha_inicio);
            document.getElementById('fecha-fin').textContent = formatDate(boleta.fecha_fin);
            document.getElementById('fecha-gracia').textContent = formatDate(boleta.fecha_gracia);
            document.getElementById('estado-contrato').textContent = boleta.estado_contrato;
            document.getElementById('estado-pago').textContent = boleta.estado_pago;
            document.getElementById('usuario-generador').textContent = boleta.usuario_generador + ' (' + boleta.tipo_usuario + ')';
            
            // Información del Responsable
            document.getElementById('nombre-responsable').textContent = boleta.nombre_responsable + ' ' + boleta.apellido_responsable;
            document.getElementById('dpi-responsable').textContent = boleta.dpi_responsable;
            
            // Información del Ocupante
            document.getElementById('nombre-ocupante').textContent = boleta.nombre_ocupante + ' ' + boleta.apellido_ocupante;
            document.getElementById('fecha-fallecimiento').textContent = formatDate(boleta.fecha_fallecimiento);
            document.getElementById('causa-muerte').textContent = boleta.causa_muerte || 'No especificada';
            document.getElementById('tipo-ocupante').textContent = boleta.tipo_ocupante;
            
            // Información del Nicho
            document.getElementById('id-nicho').textContent = boleta.id_nicho;
            document.getElementById('descripcion-nicho').textContent = boleta.descripcion_nicho;
            document.getElementById('estado-nicho').textContent = boleta.estado_nicho;
            document.getElementById('tipo-nicho').textContent = boleta.tipo_nicho;
            document.getElementById('descripcion-ubicacion').textContent = boleta.descripcion_ubicacion || 'No especificada';
            document.getElementById('nombre-calle').textContent = boleta.nombre_calle || 'No especificada';
            document.getElementById('nombre-avenida').textContent = boleta.nombre_avenida || 'No especificada';
            
            // Información de Boleta
            document.getElementById('id-boleta').textContent = boleta.id_boleta;
            document.getElementById('total-boleta').textContent = 'Q. ' + formatNumber(boleta.total);
            document.getElementById('estado-boleta').textContent = formatEstadoBoleta(boleta.estado_boleta);
            document.getElementById('fecha-emision').textContent = formatDate(boleta.fecha_emision);
        });
        
        // Modal ver comprobante
        var modalVerComprobante = document.getElementById('modalVerComprobante');
        modalVerComprobante.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var ruta = button.getAttribute('data-ruta');
            var id = button.getAttribute('data-id');
            document.getElementById('img-comprobante').src = ruta;
            document.getElementById('modalVerComprobanteLabel').textContent = 'Comprobante de Pago - Boleta #' + id;
        });
        
        // Filtrado de boletas
        document.getElementById('filtroTodos').addEventListener('click', function() {
            filtrarBoletas('todos');
            actualizarBotonesActivos(this);
        });
        
        document.getElementById('filtroPendiente').addEventListener('click', function() {
            filtrarBoletas('pago_pendiente');
            actualizarBotonesActivos(this);
        });
        
        document.getElementById('filtroRealizado').addEventListener('click', function() {
            filtrarBoletas('pago_realizado');
            actualizarBotonesActivos(this);
        });
        
        document.getElementById('filtroPagado').addEventListener('click', function() {
            filtrarBoletas('pagado');
            actualizarBotonesActivos(this);
        });
        
        // Funciones auxiliares
        function filtrarBoletas(estado) {
            var filas = document.querySelectorAll('.fila-boleta');
            filas.forEach(function(fila) {
                if (estado === 'todos' || fila.getAttribute('data-estado') === estado) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        }
        
        function actualizarBotonesActivos(botonActivo) {
            var botones = document.querySelectorAll('.btn-group .btn');
            botones.forEach(function(boton) {
                boton.classList.remove('active');
                if (boton.id.includes('filtroTodos')) {
                    boton.classList.remove('btn-secondary');
                    boton.classList.add('btn-outline-secondary');
                } else if (boton.id.includes('filtroPendiente')) {
                    boton.classList.remove('btn-warning');
                    boton.classList.add('btn-outline-warning');
                } else if (boton.id.includes('filtroRealizado')) {
                    boton.classList.remove('btn-info');
                    boton.classList.add('btn-outline-info');
                } else if (boton.id.includes('filtroPagado')) {
                    boton.classList.remove('btn-success');
                    boton.classList.add('btn-outline-success');
                }
            });
            
            botonActivo.classList.add('active');
            if (botonActivo.id.includes('filtroTodos')) {
                botonActivo.classList.remove('btn-outline-secondary');
                botonActivo.classList.add('btn-secondary');
            } else if (botonActivo.id.includes('filtroPendiente')) {
                botonActivo.classList.remove('btn-outline-warning');
                botonActivo.classList.add('btn-warning');
            } else if (botonActivo.id.includes('filtroRealizado')) {
                botonActivo.classList.remove('btn-outline-info');
                botonActivo.classList.add('btn-info');
            } else if (botonActivo.id.includes('filtroPagado')) {
                botonActivo.classList.remove('btn-outline-success');
                botonActivo.classList.add('btn-success');
            }
        }
        
        function formatDate(dateString) {
            if (!dateString) return 'No especificada';
            var date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
        }
        
        function formatNumber(number) {
            return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        function formatEstadoBoleta(estado) {
            switch (estado) {
                case 'pago_pendiente': return 'Pendiente';
                case 'pago_realizado': return 'Realizado';
                case 'pagado': return 'Pagado';
                default: return estado;
            }
        }
        
    });


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