<!-- resources/views/usuario/solicitud_contrato.blade.php -->
@extends('layouts.usuario')

@section('titulo', 'Solicitud de Contrato')

@section('titulo_seccion', 'Solicitud de Contrato para Nicho #' . $id_nicho)

@section('estilos')
<style>
    .form-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .form-section-title {
        border-bottom: 2px solid #3e6b89;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .required-field::after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('contenido')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Complete el formulario para solicitar un contrato</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('usuario.crear_solicitud_contrato') }}" method="POST">
            @csrf
            <input type="hidden" name="id_nicho" value="{{ $id_nicho }}">
            
            <div class="form-section">
                <h5 class="form-section-title">Datos del Ocupante</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label required-field">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="apellido" class="form-label required-field">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="dpi" class="form-label required-field">DPI</label>
                        <input type="text" class="form-control" id="dpi" name="dpi" required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h5 class="form-section-title">Información de Fallecimiento</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fecha_fallecimiento" class="form-label required-field">Fecha de Fallecimiento</label>
                        <input type="date" class="form-control" id="fecha_fallecimiento" name="fecha_fallecimiento" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tipo_muerte" class="form-label required-field">Tipo de Muerte</label>
                        <select class="form-select" id="tipo_muerte" name="tipo_muerte" required>
                            <option value="">Seleccione una opción</option>
                            @foreach($causasMuerte as $causa)
                                <option value="{{ $causa->id_tipo_muerte }}">{{ $causa->nombre_causa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tipo_ocupante" class="form-label required-field">Tipo de Ocupante</label>
                        <select class="form-select" id="tipo_ocupante" name="tipo_ocupante" required>
                            <option value="">Seleccione una opción</option>
                            @foreach($tiposOcupante as $tipo)
                                <option value="{{ $tipo->id_tipo_ocupante }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h5 class="form-section-title">Resumen del Contrato</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">Información Importante</h6>
                            <p>Al solicitar este contrato, usted acepta ser el responsable legal del nicho #{{ $id_nicho }} y de todos los pagos asociados al mismo.</p>
                            <p>Una vez enviada la solicitud, se generará un contrato que deberá ser aprobado por la administración. Se le notificará cuando el contrato esté listo.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('usuario.nichos') }}" class="btn btn-secondary me-md-2">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-1"></i> Enviar Solicitud
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validación para fecha de fallecimiento (no puede ser en el futuro)
    document.getElementById('fecha_fallecimiento').max = new Date().toISOString().split('T')[0];
</script>
@endsection