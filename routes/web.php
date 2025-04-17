<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AutenticacionController;

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [AutenticacionController::class, 'index']) ->name('login');
Route::post('/', [AutenticacionController::class, 'autenticacion']) ->name('autenticacion');
Route::get('/logout', [AutenticacionController::class, 'logout']) ->name('logout');
Route::get('/admin/home', [AutenticacionController::class, 'goAdminHome']) ->name('admin.home');
Route::get('/ayudante/home', [AutenticacionController::class, 'goAyudanteHome']) ->name('ayudante.home');
Route::get('/auditor/home', [AutenticacionController::class, 'goAuditorHome']) ->name('auditor.home');
Route::get('/usuario/home', [AutenticacionController::class, 'goUsuarioHome']) ->name('usuario.home');