@extends('layouts.auditoria')

@section('titulo', 'Mi Perfil')

@section('titulo_seccion', 'Mi Perfil')

@section('contenido')

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Información de perfil</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <div class="avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 3rem; background-color: #3e6b89;">
                            {{ substr($informacion->nombre_persona ?? '', 0, 1) }}
                        </div>
                        <h5>{{ $informacion->nombre_persona ?? '' }} {{ $informacion->apellido_persona ?? '' }}</h5>
                    </div>
                    <div class="col-md-9">
                        <div class="card border-0 mb-3">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Información Personal</h6>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Nombre completo:</div>
                                    <div class="col-sm-8">{{ $informacion->nombre_persona ?? 'No especificado' }} {{ $informacion->apellido_persona ?? '' }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">DPI:</div>
                                    <div class="col-sm-8">{{ $informacion->dpi ?? 'No especificado' }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Teléfono:</div>
                                    <div class="col-sm-8">{{ $informacion->telefono ?? 'No especificado' }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Correo electrónico:</div>
                                    <div class="col-sm-8">{{ $informacion->correo ?? 'No especificado' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-0">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Dirección</h6>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Dirección:</div>
                                    <div class="col-sm-8">{{ $informacion->direccion ?? 'No especificada' }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Municipio:</div>
                                    <div class="col-sm-8">{{ $informacion->municipio ?? 'No especificado' }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-muted">Departamento:</div>
                                    <div class="col-sm-8">{{ $informacion->departamento ?? 'No especificado' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            <div class="card-footer text-end">
                <a href="{{ route('auditoria.home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alertList = document.querySelectorAll('.alert');
            alertList.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection