<!-- resources/views/admin/generar_boleta.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Generar Boleta de Pago')

@section('titulo_seccion', 'Generar Boleta de Pago')

@section('estilos')
<style>
    .boleta-preview {
        border: 1px solid #ddd;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .boleta-header {
        text-align: center;
        border-bottom: 2px solid #3e6b89;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .boleta-footer {
        text-align: center;
        border-top: 1px solid #ddd;
        padding-top: 15px;
        margin-top: 30px;
        font-size: 0.8rem;
    }
    .signature-line {
        border-top: 1px solid #333;
        width: 200px;
        margin: 0 auto;
        margin-top: 40px;
        padding-top: 5px;
        text-align: center;
    }
    .boleta-logo {
        width: 100px;
        height: 100px;
        background-color: #2c4d63;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 15px;
        font-size: 40px;
    }
    .important-data {
        font-weight: bold;
        color: #2c4d63;
    }
    #canvas-boleta {
        display: none;
    }
</style>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Generar Boleta de Pago - Contrato #{{ $contrato->id_contrato }}</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Al generar la boleta, se activará el contrato después de que haya pagado dicha boleta.
                </div>
                
                <div class="boleta-preview" id="boleta-content">
                    <div class="boleta-header">
                        <div class="boleta-logo">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <h3>MUNICIPALIDAD DE QUETZALTENANGO</h3>
                        <h4>BOLETA DE PAGO - CONTRATO DE NICHO</h4>
                        <h5>No. {{ $contrato->id_contrato }}-{{ date('Ymd') }}</h5>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Fecha de Emisión:</strong> {{ date('d/m/Y') }}</p>
                            <p><strong>Válido hasta:</strong> {{ date('d/m/Y', strtotime('+5 days')) }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Monto:</strong> Q600.00</p>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Información del Contrato</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Nicho:</strong> #{{ $contrato->id_nicho }}</p>
                            <p><strong>Tipo:</strong> {{ $contrato->tipo_nicho }}</p>
                            <p><strong>Ubicación:</strong> {{ $contrato->descripcion_ubicacion ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Información del Responsable</h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $contrato->nombre_responsable }} {{ $contrato->apellido_responsable }}</p>
                            <p><strong>DPI:</strong> {{ $contrato->dpi_responsable }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ocupante:</strong> {{ $contrato->nombre_ocupante }} {{ $contrato->apellido_ocupante }}</p>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Detalles del Pago</h5>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Concepto</th>
                                        <th class="text-end">Monto (Q)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Derecho de Nicho</td>
                                        <td class="text-end">500.00</td>
                                    </tr>
                                    <tr>
                                        <td>Gastos Administrativos</td>
                                        <td class="text-end">100.00</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td><strong>Total a Pagar</strong></td>
                                        <td class="text-end"><strong>600.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="alert alert-warning text-center">
                                <strong>IMPORTANTE:</strong> Esta boleta debe ser presentada al momento de realizar el pago en Tesorería Municipal.
                            </div>
                        </div>
                    </div>
                    
                    <div class="signature-line">
                        Firma Autorizada
                    </div>
                    
                    <div class="boleta-footer">
                        <p>Sistema de Gestión de Nichos Municipales - {{ date('Y') }}</p>
                        <p>Esta boleta es válida hasta la fecha indicada. Después deberá solicitar una nueva.</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.contratos.aceptar_contrato') }}" method="POST" class="mt-4" id="form-generar-boleta">
                    @csrf
                    <input type="hidden" name="id_contrato" value="{{ $contrato->id_contrato }}">
                    <input type="hidden" name="ruta_boleta" id="ruta-boleta" value="">
                    <input type="hidden" name="imagen_boleta" id="imagen-boleta" value="">
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.contratos') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                        <button type="button" class="btn btn-success" id="btn-generar-boleta">
                            <i class="fas fa-file-invoice-dollar me-1"></i> Confirmar y Generar Boleta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Canvas oculto para generar la imagen -->
<canvas id="canvas-boleta" width="800" height="1200"></canvas>

@endsection
@section('scripts')
<!-- Incluir html2canvas para convertir HTML a imagen -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para generar la imagen de la boleta
    document.getElementById('btn-generar-boleta').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Mostrar spinner mientras se genera la imagen
        const btnGenerarBoleta = document.getElementById('btn-generar-boleta');
        const btnTextOriginal = btnGenerarBoleta.innerHTML;
        btnGenerarBoleta.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando boleta...';
        btnGenerarBoleta.disabled = true;
        
        // Capturar el contenido como imagen
        html2canvas(document.getElementById('boleta-content'), {
            scale: 2, // Mejor calidad
            useCORS: true,
            logging: false,
            backgroundColor: '#ffffff'
        }).then(canvas => {
            // Convertir el canvas a una imagen en formato base64
            const imgData = canvas.toDataURL('image/jpeg', 0.9);
            
            // Guardar la imagen en base64 en un campo oculto
            document.getElementById('imagen-boleta').value = imgData;
            
            // Generar nombre para la boleta
            const filename = 'boleta_' + {{ $contrato->id_contrato }} + '_' + Date.now() + '.jpg';
            const ruta = '/storage/boletas/' + filename;
            
            // Actualizar el campo oculto con la ruta
            document.getElementById('ruta-boleta').value = ruta;
            
            // Cambiar el texto del botón
            btnGenerarBoleta.innerHTML = '<i class="fas fa-check me-1"></i> Boleta generada, enviando...';
            
            // Enviar el formulario con la imagen en base64
            document.getElementById('form-generar-boleta').submit();
        }).catch(error => {
            console.error('Error al generar la boleta:', error);
            btnGenerarBoleta.innerHTML = btnTextOriginal;
            btnGenerarBoleta.disabled = false;
            alert('Ha ocurrido un error al generar la boleta. Por favor, inténtelo de nuevo.');
        });
    });
});
</script>
@endsection