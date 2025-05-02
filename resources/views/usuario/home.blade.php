<!-- resources/views/usuario/home.blade.php -->
@extends('layouts.usuario')

@section('titulo', 'Inicio')

@section('titulo_seccion', 'Panel de Control')

@section('contenido')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Nichos Disponibles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nichosDisponibles }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-monument fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Mis Contratos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($misContratos) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pagos Pendientes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPagosPendientes }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('usuario.nichos') }}" class="btn btn-primary mb-2">
                        <i class="fas fa-search me-2"></i>Consultar Nichos
                    </a>
                    <a href="{{ route('usuario.servicio_contratos') }}" class="btn btn-secondary mb-2">
                        <i class="fas fa-file-contract me-2"></i>Ver Mis Contratos
                    </a>
                    <a href="{{ route('usuario.servicio_contratos') }}" class="btn btn-secondary">
                        <i class="fas fa-money-bill me-2"></i>Realizar Pago
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Información del Usuario</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Nombre:</strong> {{ $persona->nombre }} {{ $persona->apellido }}
                </div>
                <div class="mb-3">
                    <strong>DPI:</strong> {{ $persona->dpi }}
                </div>
                <div class="mb-3">
                    <strong>Fecha de Registro:</strong> {{ date('d/m/Y') }}
                </div>
                <div class="d-grid">
                    <a href="{{ route('usuario.mi_perfil') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-edit me-2"></i>Ver Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection