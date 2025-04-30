<!-- resources/views/ayudante/home.blade.php -->
@extends('layouts.ayudante')

@section('titulo', 'Inicio')

@section('titulo_seccion', 'Panel Principal de Ayudante')

@section('contenido')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Bienvenido, {{ $persona->nombre ?? 'Ayudante' }}</h4>
                    <p class="text-muted">Desde este panel podrás gestionar las tareas asignadas como ayudante del sistema de nichos municipales.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Nichos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-ayudante h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Gestión de Nichos</h5>
                        <i class="fas fa-monument fa-2x text-primary"></i>
                    </div>
                    <p class="card-text">Actualizar la información de los nichos existentes.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('ayudante.gestion_nichos') }}" class="btn btn-outline-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ocupantes y Responsables -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-ayudante h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Ocupantes y Responsables</h5>
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <p class="card-text">Consulta la información de ocupantes y sus responsables.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('ayudante.gestion_usuarios') }}" class="btn btn-outline-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contratos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-ayudante h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Gestión de Contratos</h5>
                        <i class="fas fa-file-contract fa-2x text-primary"></i>
                    </div>
                    <p class="card-text">Visualiza contratos y genera boletas de pago.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('ayudante.contratos') }}" class="btn btn-outline-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-ayudante h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Gestión de Reportes</h5>
                        <i class="fas fa-chart-bar fa-2x text-primary"></i>
                    </div>
                    <p class="card-text">Genera y consulta reportes sobre nichos ocupados.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('ayudante.gestion_reportes') }}" class="btn btn-outline-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mi Perfil -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-ayudante h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Mi Perfil</h5>
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                    <p class="card-text">Actualiza tu información personal y credenciales.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('ayudante.mi_perfil') }}" class="btn btn-outline-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Resumen de Nichos</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="border bg-light rounded p-3 text-center">
                                <h3 class="text-primary">{{ $total_nichos ?? '0' }}</h3>
                                <p class="mb-0 text-muted">Total de Nichos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border bg-light rounded p-3 text-center">
                                <h3 class="text-success">{{ $nichos_disponibles ?? '0' }}</h3>
                                <p class="mb-0 text-muted">Nichos Disponibles</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border bg-light rounded p-3 text-center">
                                <h3 class="text-danger">{{ $nichos_ocupados ?? '0' }}</h3>
                                <p class="mb-0 text-muted">Nichos Ocupados</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border bg-light rounded p-3 text-center">
                                <h3 class="text-warning">{{ $contratos_activos ?? '0' }}</h3>
                                <p class="mb-0 text-muted">Contratos Activos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection