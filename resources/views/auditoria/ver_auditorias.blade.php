<!-- resources/views/auditoria/ver_auditorias.blade.php -->
@extends('layouts.auditoria')

@section('titulo', 'Ver Auditorías')

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
    .table-responsive {
        overflow-x: auto;
    }
    .filter-card {
        background-color: #f8f9fa;
        border-left: 4px solid #6c757d;
    }
    .audit-counter {
        background-color: #eef2f5;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .counter-item {
        text-align: center;
        padding: 10px;
    }
    .counter-item i {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .counter-value {
        font-size: 1.5rem;
        font-weight: bold;
    }
</style>
@endsection

@section('titulo_seccion')
    <i class="fas fa-list-alt me-2"></i>Ver Auditorías
@endsection

@section('contenido')
    <!-- Contadores de auditorías -->
    <div class="row audit-counter">
        <div class="col-md-4 counter-item">
            <i class="fas fa-clipboard-list text-primary"></i>
            <div class="counter-value">{{ count($auditorias) }}</div>
            <div class="counter-label">Total Auditorías</div>
        </div>
        <div class="col-md-4 counter-item">
            <i class="fas fa-clock text-warning"></i>
            <div class="counter-value">{{ collect($auditorias)->where('estado', 'pendiente')->count() }}</div>
            <div class="counter-label">Pendientes</div>
        </div>
        <div class="col-md-4 counter-item">
            <i class="fas fa-check-circle text-success"></i>
            <div class="counter-value">{{ collect($auditorias)->where('estado', 'completada')->count() }}</div>
            <div class="counter-label">Completadas</div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="card mb-4 filter-card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-filter me-2"></i>Filtros</h5>
            <form id="filtroForm" class="row g-3">
                <div class="col-md-4">
                    <label for="filtroTipoProblema" class="form-label">Tipo de Problema</label>
                    <select class="form-select" id="filtroTipoProblema">
                        <option value="">Todos</option>
                        <option value="Documentación incompleta">Documentación incompleta</option>
                        <option value="Pago pendiente">Pago pendiente</option>
                        <option value="Estado del nicho">Estado del nicho</option>
                        <option value="Información incorrecta">Información incorrecta</option>
                        <option value="Vencimiento de contrato">Vencimiento de contrato</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtroEstado" class="form-label">Estado</label>
                    <select class="form-select" id="filtroEstado">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="completada">Completada</option>
                        <option value="rechazada">Rechazada</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtroBusqueda" class="form-label">Búsqueda</label>
                    <input type="text" class="form-control" id="filtroBusqueda" placeholder="Auditor, Nicho...">
                </div>
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-secondary" id="limpiarFiltros">Limpiar</button>
                    <button type="button" class="btn btn-primary" id="aplicarFiltros">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Auditorías -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Lista de Auditorías</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaAuditorias">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Auditor</th>
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
                            <td>{{ $auditoria->auditor_nombre }} {{ $auditoria->auditor_apellido }}</td>
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
                            <td colspan="8" class="text-center">No hay auditorías registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modales para ver detalles de cada auditoría -->
    @foreach($auditorias as $auditoria)
    <div class="modal fade" id="verAuditoriaModal{{ $auditoria->id_auditoria }}" tabindex="-1" aria-labelledby="verAuditoriaModalLabel{{ $auditoria->id_auditoria }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="verAuditoriaModalLabel{{ $auditoria->id_auditoria }}">Detalles de Auditoría #{{ $auditoria->id_auditoria }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Fecha de Auditoría:</strong> {{ \Carbon\Carbon::parse($auditoria->fecha_hora)->format('d/m/Y H:i') }}</p>
                            <p><strong>Auditor:</strong> {{ $auditoria->auditor_nombre }} {{ $auditoria->auditor_apellido }}</p>
                            <p><strong>Contrato:</strong> #{{ $auditoria->id_contrato }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nicho:</strong> {{ $auditoria->descripcion_nicho }}</p>
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
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Detalles:</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0">{{ $auditoria->detalles_auditoria }}</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        const filtrarTabla = () => {
            const tipoProblema = document.getElementById('filtroTipoProblema').value.toLowerCase();
            const estado = document.getElementById('filtroEstado').value.toLowerCase();
            const busqueda = document.getElementById('filtroBusqueda').value.toLowerCase();
            
            const filas = document.querySelectorAll('#tablaAuditorias tbody tr');
            
            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();
                const celdaTipoProblema = fila.cells[5].textContent.toLowerCase();
                const celdaEstado = fila.cells[6].textContent.toLowerCase();
                
                const coincideTipo = tipoProblema === '' || celdaTipoProblema.includes(tipoProblema);
                const coincideEstado = estado === '' || celdaEstado.includes(estado);
                const coincideBusqueda = busqueda === '' || textoFila.includes(busqueda);
                
                if (coincideTipo && coincideEstado && coincideBusqueda) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        };
        
        document.getElementById('aplicarFiltros').addEventListener('click', filtrarTabla);
        
        document.getElementById('limpiarFiltros').addEventListener('click', () => {
            document.getElementById('filtroTipoProblema').value = '';
            document.getElementById('filtroEstado').value = '';
            document.getElementById('filtroBusqueda').value = '';
            filtrarTabla();
        });
        
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