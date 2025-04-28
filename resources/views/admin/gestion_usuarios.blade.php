<!-- resources/views/admin/gestion_usuarios.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Gestión de Usuarios')

@section('titulo_seccion')
    <i class="fas fa-users-cog me-2"></i> Gestión de Usuarios
@endsection

@section('contenido')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card card-admin h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-injured text-primary me-2"></i>
                        Ocupantes
                    </h5>
                    <p class="card-text">Gestione la información de personas fallecidas registradas en el sistema.</p>
                    <p class="text-muted small">Total: {{ count($ocupantes) }} ocupantes</p>
                    <div class="d-grid">
                        <a href="{{ route('admin.gestion_ocupantes') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-2"></i>Administrar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-admin h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-tie text-success me-2"></i>
                        Responsables
                    </h5>
                    <p class="card-text">Gestione la información de las personas responsables de los contratos.</p>
                    <p class="text-muted small">Total: {{ count($responsables) }} responsables</p>
                    <div class="d-grid">
                        <a href="{{ route('admin.gestion_responsables') }}" class="btn btn-outline-success">
                            <i class="fas fa-cog me-2"></i>Administrar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-admin h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-lock text-danger me-2"></i>
                        Usuarios Autenticados
                    </h5>
                    <p class="card-text">Administre los usuarios que tienen acceso al sistema.</p>
                    <p class="text-muted small">Total: {{ count($usuarios) }} usuarios</p>
                    <div class="d-grid">
                        <a href="{{ route('admin.gestion_usuarios_autenticados') }}" class="btn btn-outline-danger">
                            <i class="fas fa-cog me-2"></i>Administrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-admin">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Módulo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Gestión de Usuarios</strong> le permite administrar toda la información relacionada con las personas en el sistema:
                        <ul class="mt-2 mb-0">
                            <li><strong>Ocupantes:</strong> Personas fallecidas que ocupan o han ocupado un nicho.</li>
                            <li><strong>Responsables:</strong> Personas encargadas de los contratos y pagos.</li>
                            <li><strong>Usuarios Autenticados:</strong> Personas con acceso al sistema.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection