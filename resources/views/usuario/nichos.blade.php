<!-- resources/views/usuario/nichos.blade.php -->
@extends('layouts.usuario')

@section('titulo', 'Consulta de Nichos')

@section('titulo_seccion', 'Consulta de Nichos')

@section('estilos')
<style>
    .badge-disponible {
        background-color: #28a745;
        color: white;
    }
    .badge-ocupado {
        background-color: #dc3545;
        color: white;
    }
    .badge-exhumacion {
        background-color: #ffc107;
        color: black;
    }
    .filtros {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .table th {
        background-color: #3e6b89;
        color: white;
    }
</style>
@endsection

@section('contenido')
<div class="filtros">
    <form action="{{ route('usuario.nichos') }}" method="GET">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="codigo" class="form-label">Código de Nicho</label>
                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese código">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <select class="form-select" id="ubicacion" name="ubicacion">
                    <option value="">Todas las ubicaciones</option>
                    <!-- Aquí podrías cargar dinámicamente las ubicaciones -->
                    <option value="1">Avenida Central</option>
                    <option value="2">Avenida Norte</option>
                    <option value="3">Avenida Sur</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="">Todos los estados</option>
                    <option value="disponible">Disponible</option>
                    <option value="ocupado">Ocupado</option>
                    <option value="exhumacion">Exhumación</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Filtrar
            </button>
        </div>
    </form>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Listado de Nichos</h6>
        <div>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-download me-1"></i>Exportar
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Avenida</th>
                        <th>Calle</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nichos as $nicho)
                    <tr>
                        <td>{{ $nicho->id_nicho }}</td>
                        <td>{{ $nicho->nombre_tipo }}</td>
                        <td>{{ $nicho->nombre_avenida }}</td>
                        <td>{{ $nicho->nombre_calle }}</td>
                        <td>{{ $nicho->descripcion }}</td>
                        <td>
                            @if($nicho->estado == 'disponible')
                                <span class="badge badge-disponible">Disponible</span>
                            @elseif($nicho->estado == 'ocupado')
                                <span class="badge badge-ocupado">Ocupado</span>
                            @elseif($nicho->estado == 'exhumacion')
                                <span class="badge badge-exhumacion">Exhumación</span>
                            @else
                                <span class="badge bg-secondary">{{ $nicho->estado }}</span>
                            @endif
                        </td>
                        <td>
                            @if($nicho->estado == 'disponible')
                                <a href="{{ route('usuario.solicitud_contrato', $nicho->id_nicho) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-contract me-1"></i>Solicitar Contrato
                                </a>
                            @else
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detalleModal{{ $nicho->id_nicho }}">
                                    <i class="fas fa-info-circle me-1"></i>Detalles
                                </button>
                                
                                <!-- Modal de Detalles -->
                                <div class="modal fade" id="detalleModal{{ $nicho->id_nicho }}" tabindex="-1" aria-labelledby="detalleModalLabel{{ $nicho->id_nicho }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detalleModalLabel{{ $nicho->id_nicho }}">Detalles del Nicho #{{ $nicho->id_nicho }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Tipo:</strong> {{ $nicho->nombre_tipo }}</p>
                                                <p><strong>Ubicación:</strong> Avenida {{ $nicho->nombre_avenida }}, Calle {{ $nicho->nombre_calle }}</p>
                                                <p><strong>Estado:</strong> {{ ucfirst($nicho->estado) }}</p>
                                                <p><strong>Descripción:</strong> {{ $nicho->descripcion }}</p>
                                                
                                                <hr>
                                                <p class="text-muted">Para obtener más información sobre este nicho, por favor consulte con el personal autorizado.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Paginación -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Siguiente</a>
        </li>
    </ul>
</nav>
@endsection