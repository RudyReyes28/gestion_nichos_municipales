<!-- resources/views/admin/gestion_responsables.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Gestión de Responsables')

@section('estilos')
<style>
    .modal-lg {
        max-width: 90%;
    }
</style>
@endsection

@section('titulo_seccion')
    <i class="fas fa-user-tie me-2"></i> Gestión de Responsables
@endsection

@section('contenido')
    <div class="card card-admin mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Responsables
            </h5>
            <a href="{{ route('admin.gestion_usuarios') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaResponsables">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>DPI</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responsables as $responsable)
                        <tr>
                            <td>{{ $responsable->id_persona }}</td>
                            <td>{{ $responsable->nombre_persona }} {{ $responsable->apellido_persona }}</td>
                            <td>{{ $responsable->dpi }}</td>
                            <td>{{ $responsable->telefono ?: 'No disponible' }}</td>
                            <td>{{ $responsable->correo ?: 'No disponible' }}</td>
                            <td>{{ $responsable->nombre_municipio ?: 'No disponible' }}, {{ $responsable->nombre_departamento ?: 'No disponible' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                        data-bs-target="#modalEditarResponsable"
                                        data-id-persona="{{ $responsable->id_persona }}"
                                        data-nombre="{{ $responsable->nombre_persona }}"
                                        data-apellido="{{ $responsable->apellido_persona }}"
                                        data-dpi="{{ $responsable->dpi }}"
                                        data-id-contacto="{{ $responsable->id_contacto }}"
                                        data-telefono="{{ $responsable->telefono }}"
                                        data-correo="{{ $responsable->correo }}"
                                        data-id-direccion="{{ $responsable->id_direccion }}"
                                        data-descripcion-direccion="{{ $responsable->descripcion_direccion }}"
                                        data-id-municipio="{{ $responsable->id_municipio }}"
                                        data-id-departamento="{{ $responsable->id_departamento }}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn btn-sm btn-info ms-1" data-bs-toggle="modal" data-bs-target="#modalVerResponsable"
                                        data-nombre="{{ $responsable->nombre_persona }} {{ $responsable->apellido_persona }}"
                                        data-dpi="{{ $responsable->dpi }}"
                                        data-telefono="{{ $responsable->telefono }}"
                                        data-correo="{{ $responsable->correo }}"
                                        data-direccion="{{ $responsable->descripcion_direccion }}"
                                        data-municipio="{{ $responsable->nombre_municipio }}"
                                        data-departamento="{{ $responsable->nombre_departamento }}">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ver Responsable -->
    <div class="modal fade" id="modalVerResponsable" tabindex="-1" aria-labelledby="modalVerResponsableLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalVerResponsableLabel">Detalles del Responsable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Información Personal</h6>
                                <hr>
                                <p><strong>Nombre Completo:</strong> <span id="verNombre"></span></p>
                                <p><strong>DPI:</strong> <span id="verDpi"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Información de Contacto</h6>
                                <hr>
                                <p><strong>Teléfono:</strong> <span id="verTelefono"></span></p>
                                <p><strong>Correo:</strong> <span id="verCorreo"></span></p>
                                <p><strong>Dirección:</strong> <span id="verDireccion"></span></p>
                                <p><strong>Municipio:</strong> <span id="verMunicipio"></span></p>
                                <p><strong>Departamento:</strong> <span id="verDepartamento"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Responsable -->
    <div class="modal fade" id="modalEditarResponsable" tabindex="-1" aria-labelledby="modalEditarResponsableLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarResponsableLabel">Editar Responsable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.gestion_responsables.editar_responsable') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_persona" id="editIdPersona">
                        <input type="hidden" name="id_contacto" id="editIdContacto">
                        <input type="hidden" name="id_direccion" id="editIdDireccion">
                        
<div class="row">
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">Información Personal</h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="editNombre" name="nombre" required>
            </div>
            <div class="col-md-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="editApellido" name="apellido" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="dpi" class="form-label">DPI</label>
            <input type="text" class="form-control" id="editDpi" name="dpi" required>
        </div>
    </div>
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">Información de Contacto</h6>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="editTelefono" name="telefono">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="editCorreo" name="correo">
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <h6 class="fw-bold mb-3">Información de Dirección</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_departamento" class="form-label">Departamento</label>
                    <select class="form-select" id="editDepartamento" name="id_departamento">
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}">{{$departamento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_municipio" class="form-label">Municipio</label>
                    <select class="form-select" id="editMunicipio" name="id_municipio">
                        <option value="">Seleccione un municipio</option>
                        @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id_municipio }}" data-departamento="{{ $municipio->id_departamento }}">{{ $municipio->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="descripcion_direccion" class="form-label">Dirección Detallada</label>
            <textarea class="form-control" id="editDireccion" name="descripcion_direccion" rows="3"></textarea>
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</div>
</form>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Modal Ver Responsable
        const modalVerResponsable = document.getElementById('modalVerResponsable');
        if (modalVerResponsable) {
            modalVerResponsable.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                document.getElementById('verNombre').textContent = button.getAttribute('data-nombre');
                document.getElementById('verDpi').textContent = button.getAttribute('data-dpi');
                document.getElementById('verTelefono').textContent = button.getAttribute('data-telefono') || 'No disponible';
                document.getElementById('verCorreo').textContent = button.getAttribute('data-correo') || 'No disponible';
                document.getElementById('verDireccion').textContent = button.getAttribute('data-direccion') || 'No disponible';
                document.getElementById('verMunicipio').textContent = button.getAttribute('data-municipio') || 'No disponible';
                document.getElementById('verDepartamento').textContent = button.getAttribute('data-departamento') || 'No disponible';
            });
        }

        // Modal Editar Responsable
        const modalEditarResponsable = document.getElementById('modalEditarResponsable');
        if (modalEditarResponsable) {
            modalEditarResponsable.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                document.getElementById('editIdPersona').value = button.getAttribute('data-id-persona');
                document.getElementById('editIdContacto').value = button.getAttribute('data-id-contacto');
                document.getElementById('editIdDireccion').value = button.getAttribute('data-id-direccion');
                document.getElementById('editNombre').value = button.getAttribute('data-nombre');
                document.getElementById('editApellido').value = button.getAttribute('data-apellido');
                document.getElementById('editDpi').value = button.getAttribute('data-dpi');
                
                // Contacto
                document.getElementById('editTelefono').value = button.getAttribute('data-telefono') || '';
                document.getElementById('editCorreo').value = button.getAttribute('data-correo') || '';
                
                // Dirección
                document.getElementById('editDireccion').value = button.getAttribute('data-descripcion-direccion') || '';
                
                const idDepartamento = button.getAttribute('data-id-departamento');
                if (idDepartamento) {
                    document.getElementById('editDepartamento').value = idDepartamento;
                    
                    // Filtrar municipios por departamento
                    const municipioSelect = document.getElementById('editMunicipio');
                    for(let i = 0; i < municipioSelect.options.length; i++) {
                        const option = municipioSelect.options[i];
                        if(option.getAttribute('data-departamento') == idDepartamento || option.value === '') {
                            option.style.display = '';
                        } else {
                            option.style.display = 'none';
                        }
                    }
                    
                    document.getElementById('editMunicipio').value = button.getAttribute('data-id-municipio') || '';
                }
            });
        }

        // Filtrar municipios por departamento seleccionado
        const departamentoSelect = document.getElementById('editDepartamento');
        if (departamentoSelect) {
            departamentoSelect.addEventListener('change', function() {
                const idDepartamento = this.value;
                const municipioSelect = document.getElementById('editMunicipio');
                
                municipioSelect.value = '';
                
                for(let i = 0; i < municipioSelect.options.length; i++) {
                    const option = municipioSelect.options[i];
                    if(option.getAttribute('data-departamento') == idDepartamento || option.value === '') {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            });
        }
    });
</script>
@endsection