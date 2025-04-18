<!-- resources/views/admin/contratos.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Gestión de Contratos')

@section('titulo_seccion', 'Gestión de Contratos')

@section('estilos')
<style>
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-aprobado {
        background-color: #28a745;
        color: white;
    }
    .badge-rechazado {
        background-color: #dc3545;
        color: white;
    }
    .badge-pagado {
        background-color: #198754;
        color: white;
    }
    .badge-no-pagado {
        background-color: #fd7e14;
        color: white;
    }
    .contrato-card {
        transition: transform 0.2s;
    }
    .contrato-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('contenido')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filtrar Contratos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3" role="group">
                            <a href="{{ route('admin.contratos') }}" class="btn {{ request()->query('estado') ? 'btn-outline-primary' : 'btn-primary' }}">Todos</a>
                            <a href="{{ route('admin.contratos') }}?estado=solicitado" class="btn {{ request()->query('estado') == 'solicitado' ? 'btn-primary' : 'btn-outline-primary' }}">Solicitados</a>
                            <a href="{{ route('admin.contratos') }}?estado=activo" class="btn {{ request()->query('estado') == 'activo' ? 'btn-primary' : 'btn-outline-primary' }}">Activo</a>
                            <a href="{{ route('admin.contratos') }}?estado=exhumacion" class="btn {{ request()->query('estado') == 'exhumacion' ? 'btn-primary' : 'btn-outline-primary' }}">Exhumación</a>
                            <a href="{{ route('admin.contratos') }}?estado=rechazado" class="btn {{ request()->query('estado') == 'rechazado' ? 'btn-primary' : 'btn-outline-primary' }}">Rechazados</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Buscar por nombre, DPI, etc." aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if(count($contratos) > 0)
        @foreach($contratos as $contrato)
        <div class="col-md-6 mb-4">
            <div class="card contrato-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Contrato #{{ $contrato->id_contrato }}</h5>
                    <div>
                        <span class="badge badge-contrato badge-{{ strtolower($contrato->estado_contrato) }}">
                            {{ $contrato->estado_contrato }}
                        </span>
                        <span class="badge badge-contrato badge-{{ $contrato->estado_pago == 'pagado' ? 'pagado' : 'no-pagado' }}">
                            {{ $contrato->estado_pago }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Información del Nicho</h6>
                    <p class="card-text">
                        <strong>Nicho:</strong> #{{ $contrato->id_nicho }} - {{ $contrato->descripcion_nicho }}<br>
                        <strong>Tipo:</strong> {{ $contrato->tipo_nicho }}<br>
                        <strong>Ubicación:</strong> {{ $contrato->descripcion_ubicacion ?? 'N/A' }}, Calle {{ $contrato->nombre_calle ?? 'N/A' }}, Avenida {{ $contrato->nombre_avenida ?? 'N/A' }}
                    </p>
                    
                    <h6 class="card-subtitle mb-2 text-muted mt-3">Información del Ocupante</h6>
                    <p class="card-text">
                        <strong>Nombre:</strong> {{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}<br>
                        <strong>Fecha fallecimiento:</strong> {{ \Carbon\Carbon::parse($contrato->fecha_fallecimiento)->format('d/m/Y') }}<br>
                        <strong>Causa:</strong> {{ $contrato->causa_muerte ?? 'No especificada' }}
                    </p>
                    
                    <h6 class="card-subtitle mb-2 text-muted mt-3">Información del Responsable</h6>
                    <p class="card-text">
                        <strong>Nombre:</strong> {{ $contrato->nombre_responsable }} {{ $contrato->apellido_responsable }}<br>
                        <strong>DPI:</strong> {{ $contrato->dpi_responsable }}
                    </p>
                    
                    
                    @if($contrato->estado_contrato == 'solicitado')
                    <div class="d-flex mt-3">
                        <a href="{{ route('admin.contratos.generar_boleta', $contrato->id_contrato) }}" class="btn btn-success me-2">
                            <i class="fas fa-check-circle me-1"></i> Aprobar y Generar Boleta
                        </a>
                        <a href="{{ route('admin.contratos.rechazar', $contrato->id_contrato) }}" class="btn btn-danger" onclick="return confirm('¿Está seguro que desea rechazar este contrato?')">
                            <i class="fas fa-times-circle me-1"></i> Rechazar
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-footer text-muted">
                    <small>Generado por: {{ $contrato->usuario_generador }} ({{ $contrato->tipo_usuario }})</small>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="col-12">
            <div class="alert alert-info">
                No se encontraron contratos con los filtros seleccionados.
            </div>
        </div>
    @endif
</div>

<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Paginación de contratos">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection