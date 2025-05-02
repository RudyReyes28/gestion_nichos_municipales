@extends('layouts.ayudante')

@section('titulo')
    Gestión de Reportes
@endsection

@section('titulo_seccion')
    Gestión de Reportes
@endsection

@section('estilos')
<style>
    .card-dashboard {
        transition: all 0.3s ease;
        border-left: 4px solid #3e6b89;
    }
    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-counter {
        padding: 20px;
        background-color: #fff;
        height: 100%;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: .3s linear all;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .card-counter.primary {
        background-color: #3e6b89;
        color: #FFF;
    }
    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }
    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
    }
    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }
    .card-counter.warning {
        background-color: #ffa726;
        color: #FFF;
    }
    .card-counter i {
        font-size: 4em;
        opacity: 0.3;
    }
    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
        font-weight: 700;
    }
    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        font-style: italic;
        text-transform: capitalize;
        opacity: 0.7;
        display: block;
        font-size: 18px;
    }
    .tab-content {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 5px 5px;
    }
    .nav-tabs .nav-link.active {
        font-weight: bold;
        color: #3e6b89;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    .nav-tabs .nav-link:not(.active) {
        color: #6c757d;
    }
    .nav-tabs .nav-link:hover {
        color: #3e6b89;
    }
</style>
@endsection

@section('contenido')
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Este módulo permite visualizar reportes estadísticos y operativos del sistema de gestión de nichos.
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card-counter primary position-relative">
                <i class="fas fa-monument position-absolute start-0 top-50 translate-middle-y ms-4"></i>
                <span class="count-numbers" id="contadorTotalNichos">{{ $nichosOcupados + $nichosDisponibles }}</span>
                <span class="count-name">Total de Nichos</span>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card-counter success position-relative">
                <i class="fas fa-check-circle position-absolute start-0 top-50 translate-middle-y ms-4"></i>
                <span class="count-numbers" id="contadorNichosDisponibles">{{ $nichosDisponibles }}</span>
                <span class="count-name">Nichos Disponibles</span>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card-counter danger position-relative">
                <i class="fas fa-times-circle position-absolute start-0 top-50 translate-middle-y ms-4"></i>
                <span class="count-numbers" id="contadorNichosVencidos">{{$nichosOcupados }}</span>
                <span class="count-name">Nichos Ocupados</span>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card-counter info position-relative">
                <i class="fas fa-file-contract position-absolute start-0 top-50 translate-middle-y ms-4"></i>
                <span class="count-numbers" id="contadorContratosVigentes">{{ count($contratos) }}</span>
                <span class="count-name">Total Contratos</span>
            </div>
        </div>
        
    </div>


    <!-- Tabs para diferentes reportes -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="reportesTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nichos-tab" data-bs-toggle="tab" data-bs-target="#nichos" type="button" role="tab">
                        <i class="fas fa-monument me-2"></i>Nichos
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contratos-tab" data-bs-toggle="tab" data-bs-target="#contratos" type="button" role="tab">
                        <i class="fas fa-file-contract me-2"></i>Contratos
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="reportesTabsContent">
                <!-- Tab Nichos -->
                <div class="tab-pane fade show active" id="nichos" role="tabpanel">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Nichos Disponibles</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Descripción</th>
                                                    <th>Tipo</th>
                                                    <th>Ubicación</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($nichosInfo as $nicho)
                                                    @if($nicho->estado_nicho != 'ocupado')
                                                        <tr>
                                                            <td>{{ $nicho->id_nicho }}</td>
                                                            <td>{{ $nicho->descripcion_nicho }}</td>
                                                            <td>{{ $nicho->tipo_nicho }}</td>
                                                            <td>{{ $nicho->ubicacion }}</td>
                                                            <td>
                                                                <span class="badge bg-success">Disponible</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Listado de Nichos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="tablaNichos">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Descripción</th>
                                                    <th>Tipo</th>
                                                    <th>Ubicación</th>
                                                    <th>Detalle</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($nichosInfo as $nicho)
                                                    <tr>
                                                        <td>{{ $nicho->id_nicho }}</td>
                                                        <td>{{ $nicho->descripcion_nicho }}</td>
                                                        <td>{{ $nicho->tipo_nicho }}</td>
                                                        <td>{{ $nicho->ubicacion }}</td>
                                                        <td>{{ $nicho->ubicacion_detalle }}</td>
                                                        <td>
                                                            @if($nicho->estado_nicho == 'ocupado')
                                                                <span class="badge bg-danger">Ocupado</span>
                                                            @else
                                                                <span class="badge bg-success">Disponible</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab Contratos -->
                <div class="tab-pane fade" id="contratos" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Listado de Contratos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="tablaContratos">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nicho</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($contratos as $contrato)
                                                    <tr>
                                                        <td>{{ $contrato->id_contrato }}</td>
                                                        <td>{{ $contrato->descripcion_nicho }}</td>
                                                        <td>{{ $contrato->fecha_inicio }}</td>
                                                        <td>{{ $contrato->fecha_fin }}</td>
                                                        <td>
                                                            @if($contrato->estado_contrato == 'activo')
                                                                <span class="badge bg-success">Vigente</span>
                                                            @elseif($contrato->estado_contrato == 'vencido')
                                                                <span class="badge bg-danger">Vencido</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ $contrato->estado_contrato }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Manejo de tabs para mantener el estado al recargar
    const triggerTabList = document.querySelectorAll('#reportesTabs button');
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('click', function(event) {
            // Guardar el tab seleccionado en localStorage
            localStorage.setItem('activeReportTab', this.getAttribute('id'));
        });
    });

    // Restaurar tab activo desde localStorage
    const activeTabId = localStorage.getItem('activeReportTab');
    if (activeTabId) {
        const activeTab = document.querySelector('#' + activeTabId);
        if (activeTab) {
            const tab = new bootstrap.Tab(activeTab);
            tab.show();
        }
    }

    // Animación para tarjetas de estadísticas
    $('.card-counter').each(function() {
        const $this = $(this);
        const countTo = parseInt($this.find('.count-numbers').text().replace(/,/g, ''));
        
        $({ countNum: 0 }).animate({
            countNum: countTo
        }, {
            duration: 1000,
            easing: 'swing',
            step: function() {
                if (isNaN(this.countNum)) {
                    $this.find('.count-numbers').text('0');
                } else {
                    const formattedNumber = Math.floor(this.countNum).toLocaleString('es-GT');
                    $this.find('.count-numbers').text(formattedNumber);
                }
            },
            complete: function() {
                const formattedNumber = Math.floor(this.countNum).toLocaleString('es-GT');
                $this.find('.count-numbers').text(formattedNumber);
            }
        });
    });

    // Tooltips y popovers de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});
</script>
@endsection