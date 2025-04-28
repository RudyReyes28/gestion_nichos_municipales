<!-- resources/views/admin/gestion_usuarios_autenticados.blade.php -->
@extends('layouts.admin')

@section('titulo', 'Gestión de Usuarios Autenticados')

@section('estilos')
<style>
    .badge-usuario {
        font-size: 0.8rem;
        padding: 5px 8px;
    }
    .avatar-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin-right: 10px;
    }
    .modal-lg {
        max-width: 90%;
    }
</style>
@endsection

@section('titulo_seccion')
    <i class="fas fa-user-lock me-2"></i> Gestión de Usuarios Autenticados
@endsection

@section('contenido')
    <div class="card card-admin mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Lista de Usuarios
            </h5>
            <div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </button>
                <a href="{{ route('admin.gestion_usuarios') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaUsuarios">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Contacto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id_autenticacion }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-small bg-{{ $usuario->estado_usuario == 'activo' ? 'success' : 'secondary' }}">
                                        {{ substr($usuario->nombre_usuario, 0, 1) }}
                                    </div>
                                    {{ $usuario->nombre_usuario }}
                                </div>
                            </td>
                            <td>{{ $usuario->nombre_persona }} {{ $usuario->apellido_persona }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $usuario->tipo_usuario }}</span>
                            </td>
                            <td>
                                @if($usuario->estado_usuario == 'activo')
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    <i class="fas fa-phone me-1"></i> {{ $usuario->telefono ?: 'No disponible' }}<br>
                                    <i class="fas fa-envelope me-1"></i> {{ $usuario->correo ?: 'No disponible' }}
                                </small>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerUsuario"
                                        data-usuario="{{ $usuario->nombre_usuario }}"
                                        data-nombre="{{ $usuario->nombre_persona }} {{ $usuario->apellido_persona }}"
                                        data-dpi="{{ $usuario->dpi }}"
                                        data-tipo="{{ $usuario->tipo_usuario }}"
                                        data-estado="{{ $usuario->estado_usuario }}"
                                        data-telefono="{{ $usuario->telefono }}"
                                        data-correo="{{ $usuario->correo }}"
                                        data-direccion="{{ $usuario->descripcion_direccion }}"
                                        data-municipio="{{ $usuario->nombre_municipio }}"
                                        data-departamento="{{ $usuario->nombre_departamento }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @if($usuario->estado_usuario == 'activo')
                                    <a href="{{ route('admin.gestion_usuarios_autenticados.desactivar_usuario', $usuario->id_autenticacion) }}" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('¿Está seguro que desea desactivar este usuario?')">
                                        <i class="fas fa-user-slash"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.gestion_usuarios_autenticados.activar_usuario', $usuario->id_autenticacion) }}" 
                                       class="btn btn-sm btn-success" 
                                       onclick="return confirm('¿Está seguro que desea activar este usuario?')">
                                        <i class="fas fa-user-check"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ver Usuario -->
    <div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-labelledby="modalVerUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalVerUsuarioLabel">Detalles del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="fw-bold">Información de Usuario</h6>
                                <hr>
                                <p><strong>Nombre de Usuario:</strong> <span id="verUsuario"></span></p>
                                <p><strong>Tipo de Usuario:</strong> <span id="verTipo"></span></p>
                                <p><strong>Estado:</strong> <span id="verEstado"></span></p>
                            </div>
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

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalCrearUsuarioLabel">Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.gestion_usuarios_autenticados.crear_usuario') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Información de Usuario</h6>
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contrasenia" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_tipo_usuario" class="form-label">Tipo de Usuario</label>
                                    <select class="form-select" id="id_tipo_usuario" name="id_tipo_usuario" required>
                                        @foreach(\App\Models\TipoUsuario::all() as $tipo)
                                            <option value="{{ $tipo->id_tipo_usuario }}">{{ $tipo->tipo_usuario }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Información Personal</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="dpi" class="form-label">DPI</label>
                                    <input type="text" class="form-control" id="dpi" name="dpi" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-bold mb-3">Información de Contacto</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="correo" name="correo">
                                        </div>
                                    </div>
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
                                            <select class="form-select" id="id_departamento" name="id_departamento">
                                                <option value="">Seleccione un departamento</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_municipio" class="form-label">Municipio</label>
                                            <select class="form-select" id="id_municipio" name="id_municipio">
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
                                    <textarea class="form-control" id="descripcion_direccion" name="descripcion_direccion" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        

        // Modal Ver Usuario
        const modalVerUsuario = document.getElementById('modalVerUsuario');
        if (modalVerUsuario) {
            modalVerUsuario.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                
                document.getElementById('verUsuario').textContent = button.getAttribute('data-usuario');
                document.getElementById('verNombre').textContent = button.getAttribute('data-nombre');
                document.getElementById('verDpi').textContent = button.getAttribute('data-dpi');
                document.getElementById('verTipo').textContent = button.getAttribute('data-tipo');
                
                const estado = button.getAttribute('data-estado');
                const estadoElement = document.getElementById('verEstado');
                estadoElement.textContent = estado.charAt(0).toUpperCase() + estado.slice(1);
                estadoElement.className = estado === 'activo' ? 'badge bg-success' : 'badge bg-secondary';
                
                document.getElementById('verTelefono').textContent = button.getAttribute('data-telefono') || 'No disponible';
                document.getElementById('verCorreo').textContent = button.getAttribute('data-correo') || 'No disponible';
                document.getElementById('verDireccion').textContent = button.getAttribute('data-direccion') || 'No disponible';
                document.getElementById('verMunicipio').textContent = button.getAttribute('data-municipio') || 'No disponible';
                document.getElementById('verDepartamento').textContent = button.getAttribute('data-departamento') || 'No disponible';
            });
        }

        // Filtrar municipios por departamento seleccionado (modal crear usuario)
        const departamentoSelect = document.getElementById('id_departamento');
        if (departamentoSelect) {
            departamentoSelect.addEventListener('change', function() {
                const idDepartamento = this.value;
                const municipioSelect = document.getElementById('id_municipio');
                
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