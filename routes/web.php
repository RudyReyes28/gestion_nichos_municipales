<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AutenticacionController;
use App\Http\Controllers\usuario\ServicioNichosController;
use App\Http\Controllers\admin\ContratoController;
use App\Http\Controllers\usuario\ServicioContratosController;
use App\Http\Controllers\usuario\MisNichosController;
use App\Http\Controllers\usuario\MiPerfilController;
use App\Http\Controllers\admin\BoletaPagoController;

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [AutenticacionController::class, 'index']) ->name('login');
Route::post('/', [AutenticacionController::class, 'autenticacion']) ->name('autenticacion');
Route::get('/logout', [AutenticacionController::class, 'logout']) ->name('logout');
Route::get('/ayudante/home', [AutenticacionController::class, 'goAyudanteHome']) ->name('ayudante.home');
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

// Rutas para el administrador
Route::get('/admin/home', [AutenticacionController::class, 'goAdminHome']) ->name('admin.home');
Route::get('/admin/contratos', [ContratoController::class, 'contratos']) ->name('admin.contratos');
Route::get('/admin/contratos/rechazar/{id_contrato}', [ContratoController::class, 'rechazarContrato']) ->name('admin.contratos.rechazar');
Route::get('/admin/contratos/generar_boleta/{id}', [ContratoController::class, 'generarBoleta']) ->name('admin.contratos.generar_boleta');
Route::post('/admin/contratos/generar_boleta', [ContratoController::class, 'aceptarContrato']) ->name('admin.contratos.aceptar_contrato');
Route::get('/admin/boleta_pago', [BoletaPagoController::class, 'index']) ->name('admin.boleta_pago');
Route::get('/admin/boleta_pago/aceptar_pago/{id_boleta}', [BoletaPagoController::class, 'aceptarPagoBoleta']) ->name('admin.boleta_pago.aceptar_pago');