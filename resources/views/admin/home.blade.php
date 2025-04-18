<!-- resources/views/admin/home.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Inicio')

@section('titulo_seccion', 'Panel de Control')

@section('contenido')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card card-admin h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-file-contract text-primary me-2"></i>Gestión de Contratos</h5>
                <p class="card-text">Administra los contratos pendientes, aprueba o rechaza solicitudes.</p>
                <a href="{{ route('admin.contratos') }}" class="btn btn-primary">Gestionar Contratos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-admin h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-exchange-alt text-success me-2"></i>Gestión de Exhumaciones</h5>
                <p class="card-text">Administra las solicitudes de exhumación y su procesamiento.</p>
                <a href="#" class="btn btn-success">Gestionar Exhumaciones</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-admin h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-monument text-secondary me-2"></i>Gestión de Nichos</h5>
                <p class="card-text">Gestiona los nichos disponibles, ocupados y sus detalles.</p>
                <a href="#" class="btn btn-secondary">Gestionar Nichos</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Contratos Pendientes</h5>
            </div>
            <div class="card-body">
                <p>Revisa los contratos pendientes de aprobación.</p>
                <a href="{{ route('admin.contratos') }}?estado=pendiente" class="btn btn-outline-primary">Ver Pendientes</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Boletas Pendientes</h5>
            </div>
            <div class="card-body">
                <p>Revisa las boletas pendientes de pago.</p>
                <a href="#" class="btn btn-outline-success">Ver Boletas</a>
            </div>
        </div>
    </div>
</div>
@endsection