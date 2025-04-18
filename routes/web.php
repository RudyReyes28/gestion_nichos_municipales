<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AutenticacionController;
use App\Http\Controllers\usuario\ServicioNichosController;
use App\Http\Controllers\admin\ContratoController;

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

// Rutas para el administrador
Route::get('/admin/home', [AutenticacionController::class, 'goAdminHome']) ->name('admin.home');
Route::get('/admin/contratos', [ContratoController::class, 'contratos']) ->name('admin.contratos');
Route::get('/admin/contratos/rechazar/{id_contrato}', [ContratoController::class, 'rechazarContrato']) ->name('admin.contratos.rechazar');
Route::get('/admin/contratos/generar_boleta/{id}', [ContratoController::class, 'generarBoleta']) ->name('admin.contratos.generar_boleta');
Route::post('/admin/contratos/generar_boleta', [ContratoController::class, 'aceptarContrato']) ->name('admin.contratos.aceptar_contrato');