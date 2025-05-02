<!-- resources/views/auditoria/home.blade.php -->
@extends('layouts.auditoria')

@section('titulo', 'Inicio')

@section('titulo_seccion', 'Panel de Control de Auditoría')

@section('contenido')
<div class="container-fluid">
    <!-- Tarjetas de resumen -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="audit-stat bg-info-light">
                <i class="fas fa-clipboard-check text-primary"></i>
                <h3>{{ $total_auditorias ?? 0 }}</h3>
                <p class="text-muted mb-0">Auditorías Realizadas</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="audit-stat bg-success-light">
                <i class="fas fa-check-circle text-success"></i>
                <h3>{{ $auditorias_completadas ?? 0 }}</h3>
                <p class="text-muted mb-0">Auditorías Completadas</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="audit-stat bg-warning-light">
                <i class="fas fa-exclamation-triangle text-warning"></i>
                <h3>{{ $auditorias_pendientes ?? 0 }}</h3>
                <p class="text-muted mb-0">Auditorías Pendientes</p>
            </div>
        </div>
    </div>

   
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">Accesos Rápidos</h4>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card card-audit h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-tasks text-primary me-2"></i>Nueva Auditoría</h5>
                    <p class="card-text">Iniciar un nuevo proceso de auditoría en el sistema.</p>
                    <a href="#" class="btn btn-primary">Comenzar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card card-audit h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-list-alt text-success me-2"></i>Ver Auditorías</h5>
                    <p class="card-text">Consultar el listado de auditorías realizadas y en proceso.</p>
                    <a href="#" class="btn btn-success">Consultar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card card-audit h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-chart-bar text-info me-2"></i>Reportes</h5>
                    <p class="card-text">Acceder a los diferentes reportes del sistema.</p>
                    <a href="#" class="btn btn-info text-white">Ver Reportes</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card card-audit h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-cog text-secondary me-2"></i>Mi Perfil</h5>
                    <p class="card-text">Administrar información de tu cuenta y preferencias.</p>
                    <a href="#" class="btn btn-secondary">Editar Perfil</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('scripts')

@endsection