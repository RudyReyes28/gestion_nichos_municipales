<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AutenticacionController;
use App\Http\Controllers\usuario\ServicioNichosController;
use App\Http\Controllers\usuario\ServicioContratosController;
use App\Http\Controllers\usuario\MisNichosController;
use App\Http\Controllers\usuario\MiPerfilController;
use App\Http\Controllers\usuario\ExhumacionController;

use App\Http\Controllers\admin\ContratoController;
use App\Http\Controllers\admin\BoletaPagoController;
use App\Http\Controllers\admin\GestionExhumacionController;
use App\Http\Controllers\admin\GestionUsuariosController;
use App\Http\Controllers\admin\GestionNichosController;
use App\Http\Controllers\admin\MiAdminPerfilController;
use App\Http\Controllers\admin\ReportesController;

use App\Http\Controllers\ayudante\GestionAyudanteContratosController;
use App\Http\Controllers\ayudante\GestionAyudanteNichosController;
use App\Http\Controllers\ayudante\GestionAyudanteReportesController;
use App\Http\Controllers\ayudante\GestionAyudanteUsuariosController;
use App\Http\Controllers\ayudante\MiPerfilAyudanteController;


/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [AutenticacionController::class, 'index']) ->name('login');
Route::post('/', [AutenticacionController::class, 'autenticacion']) ->name('autenticacion');
Route::get('/logout', [AutenticacionController::class, 'logout']) ->name('logout');
Route::get('/auditor/home', [AutenticacionController::class, 'goAuditorHome']) ->name('auditor.home');

// Rutas para el usuario
Route::get('/usuario/home', [AutenticacionController::class, 'goUsuarioHome']) ->name('usuario.home');
Route::get('/usuario/nichos', [ServicioNichosController::class, 'manejoNichos']) ->name('usuario.nichos');
Route::get('/usuario/solicitud_contrato/{id_nicho}', [ServicioNichosController::class, 'solicitudContrato']) ->name('usuario.solicitud_contrato');
Route::post('/usuario/solicitud_contrato', [ServicioNichosController::class, 'crearSolicitudContrato']) ->name('usuario.crear_solicitud_contrato');
Route::get('/usuario/servicio_contratos', [ServicioContratosController::class, 'index']) ->name('usuario.servicio_contratos');
Route::get('/usuario/servicio_contratos/pagar_boleta/{id_boleta}', [ServicioContratosController::class, 'pagarBoleta']) ->name('usuario.pagar_boleta');
Route::get('/usuario/mis_nichos', [MisNichosController::class, 'index']) ->name('usuario.mis_nichos');
Route::get('/usuario/mi_perfil', [MiPerfilController::class, 'index']) ->name('usuario.mi_perfil');
Route::get('/usuario/exhumacion', [ExhumacionController::class, 'index']) ->name('usuario.exhumacion');
Route::post('/usuario/exhumacion', [ExhumacionController::class, 'registrarExhumacion']) ->name('usuario.registrar_exhumacion');
Route::get('/usuario/exhumacion/mis_exhumaciones', [ExhumacionController::class, 'misExhumaciones']) ->name('usuario.mis_exhumaciones');


// Rutas para el administrador
Route::get('/admin/home', [AutenticacionController::class, 'goAdminHome']) ->name('admin.home');
Route::get('/admin/contratos', [ContratoController::class, 'contratos']) ->name('admin.contratos');
Route::get('/admin/contratos/rechazar/{id_contrato}', [ContratoController::class, 'rechazarContrato']) ->name('admin.contratos.rechazar');
Route::get('/admin/contratos/generar_boleta/{id}', [ContratoController::class, 'generarBoleta']) ->name('admin.contratos.generar_boleta');
Route::post('/admin/contratos/generar_boleta', [ContratoController::class, 'aceptarContrato']) ->name('admin.contratos.aceptar_contrato');
Route::get('/admin/boleta_pago', [BoletaPagoController::class, 'index']) ->name('admin.boleta_pago');
Route::get('/admin/boleta_pago/aceptar_pago/{id_boleta}', [BoletaPagoController::class, 'aceptarPagoBoleta']) ->name('admin.boleta_pago.aceptar_pago');
Route::get('/admin/exhumacion', [GestionExhumacionController::class, 'index']) ->name('admin.gestion_exhumacion');
Route::get('/admin/exhumacion/ver_exhumaciones', [GestionExhumacionController::class, 'verTodasExhumaciones']) ->name('admin.gestion_exhumacion.ver_exhumaciones');
Route::get('/admin/exhumacion/aceptar/{id_exhumacion}', [GestionExhumacionController::class, 'aceptarExhumacion']) ->name('admin.gestion_exhumacion.aceptar');
Route::get('/admin/exhumacion/rechazar/{id_exhumacion}', [GestionExhumacionController::class, 'rechazarExhumacion']) ->name('admin.gestion_exhumacion.rechazar');

Route::get('/admin/gestion_usuarios', [GestionUsuariosController::class, 'index']) ->name('admin.gestion_usuarios');
Route::get('/admin/gestion_usuarios/gestionar_ocupantes', [GestionUsuariosController::class, 'gestionarOcupantes']) ->name('admin.gestion_ocupantes');
Route::post('/admin/gestion_usuarios/gestionar_ocupantes/editar_ocupante', [GestionUsuariosController::class, 'editarOcupante']) ->name('admin.gestion_ocupantes.editar_ocupante');
Route::get('/admin/gestion_usuarios/gestionar_responsables', [GestionUsuariosController::class, 'gestionarResponsables']) ->name('admin.gestion_responsables');
Route::post('/admin/gestion_usuarios/gestionar_responsables/editar_responsable', [GestionUsuariosController::class, 'editarResponsable']) ->name('admin.gestion_responsables.editar_responsable');
Route::get('/admin/gestion_usuarios/gestionar_usuarios', [GestionUsuariosController::class, 'gestionarUsuariosAutenticados']) ->name('admin.gestion_usuarios_autenticados');
Route::get('/admin/gestion_usuarios/gestionar_usuarios/activar_usuario/{id_usuario}', [GestionUsuariosController::class, 'activarUsuario']) ->name('admin.gestion_usuarios_autenticados.activar_usuario');
Route::get('/admin/gestion_usuarios/gestionar_usuarios/desactivar_usuario/{id_usuario}', [GestionUsuariosController::class, 'eliminarUsuario']) ->name('admin.gestion_usuarios_autenticados.desactivar_usuario');
Route::post('/admin/gestion_usuarios/gestionar_usuarios/crear_usuario', [GestionUsuariosController::class, 'crearUsuario']) ->name('admin.gestion_usuarios_autenticados.crear_usuario');

Route::get('/admin/gestion_nichos', [GestionNichosController::class, 'index']) ->name('admin.gestion_nichos');
Route::post('/admin/gestion_nichos/crear_nicho', [GestionNichosController::class, 'crearNicho']) ->name('admin.gestion_nichos.crear_nicho');
Route::get('/admin/mi_perfil', [MiAdminPerfilController::class, 'index']) ->name('admin.mi_perfil');
Route::get('/admin/gestion_reportes', [ReportesController::class, 'index'])->name('admin.gestion_reportes');

// Rutas para el ayudante
Route::get('/ayudante/home', [AutenticacionController::class, 'goAyudanteHome']) ->name('ayudante.home');
Route::get('/ayudante/contratos', [GestionAyudanteContratosController::class, 'contratos']) ->name('ayudante.contratos');
Route::get('/ayudante/contratos/rechazar/{id_contrato}', [GestionAyudanteContratosController::class, 'rechazarContrato']) ->name('ayudante.contratos.rechazar');
Route::get('/ayudante/contratos/generar_boleta/{id_contrato}', [GestionAyudanteContratosController::class, 'generarBoleta']) ->name('ayudante.contratos.generar_boleta');
Route::post('/ayudante/contratos/generar_boleta', [GestionAyudanteContratosController::class, 'aceptarContrato']) ->name('ayudante.contratos.aceptar_contrato');

Route::get('/ayudante/gestion_nichos', [GestionAyudanteNichosController::class, 'index']) ->name('ayudante.gestion_nichos');
Route::post('/ayudante/gestion_nichos/crear_nicho', [GestionAyudanteNichosController::class, 'crearNicho']) ->name('ayudante.gestion_nichos.crear_nicho');

Route::get('/ayudante/gestion_usuarios', [GestionAyudanteUsuariosController::class, 'index'])->name('ayudante.gestion_usuarios');
Route::get('/ayudante/gestion_usuarios/gestionar_ocupantes', [GestionAyudanteUsuariosController::class, 'gestionarOcupantes'])->name('ayudante.gestion_ocupantes');
Route::post('/ayudante/gestion_usuarios/gestionar_ocupantes/editar_ocupante', [GestionAyudanteUsuariosController::class, 'editarOcupante'])->name('ayudante.gestion_ocupantes.editar_ocupante');
Route::get('/ayudante/gestion_usuarios/gestionar_responsables', [GestionAyudanteUsuariosController::class, 'gestionarResponsables'])->name('ayudante.gestion_responsables');
Route::post('/ayudante/gestion_usuarios/gestionar_responsables/editar_responsable', [GestionAyudanteUsuariosController::class, 'editarResponsable'])->name('ayudante.gestion_responsables.editar_responsable');

Route::get('/ayudante/gestion_reportes', [GestionAyudanteReportesController::class, 'index'])->name('ayudante.gestion_reportes');
Route::get('/ayudante/mi_perfil', [MiPerfilAyudanteController::class, 'index']) ->name('ayudante.mi_perfil');