<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContratoNicho;
use Illuminate\Http\Request;
use App\Models\Autenticacion;
use App\Models\Persona;
use Illuminate\Support\Facades\Session;
use App\Models\Auditoria;
use App\Models\BoletaPago;

class AutenticacionController extends Controller
{
    //
    public function index()
    {
        return view('login');
    }

    public function autenticacion(Request $request)
    {
        $usuario = $request->input('usuario');
        $contrasenia = $request->input('contrasenia');

        $autenticacion = Autenticacion::getAutenticacionByUsuario($usuario);

        if ($autenticacion && $autenticacion[0]->estado == 'activo') {
            if (password_verify($contrasenia, $autenticacion[0]->contrasenia)) {
                Session::put('id_autenticacion', $autenticacion[0]->id_autenticacion);
                Session::put('id_persona', $autenticacion[0]->id_persona);
                switch ($autenticacion[0]->id_tipo_usuario) {
                    case 1:
                        return redirect()->route('admin.home');
                    case 2:
                        return redirect()->route('ayudante.home');
                    case 3:
                        return redirect()->route('auditoria.home');
                    case 4:
                        return redirect()->route('usuario.home');
                    default:
                        return redirect()->back()->withErrors(['error' => 'Tipo de usuario no válido']);
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Contraseña incorrecta']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Usuario no encontrado']);
        }
    }

    public function goAdminHome(){
        if (!Session::has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = Session::get('id_autenticacion');
        $id_persona = Session::get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        return view('admin.home', compact('persona'));
    }

    public function goAyudanteHome(){
        if (!Session::has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = Session::get('id_autenticacion');
        $id_persona = Session::get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        return view('ayudante.home', compact('persona'));
    }
    public function goAuditorHome(){
        if (!Session::has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = Session::get('id_autenticacion');
        $id_persona = Session::get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        return view('auditoria.home', compact('persona'));
    }
    public function goUsuarioHome(){
        if (!Session::has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = Session::get('id_autenticacion');
        $id_persona = Session::get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        //algunos reportes 
        $nichosDisponibles = Auditoria::getTotalNichosByEstado('disponible');
        $misContratos =ContratoNicho::getAllInfoContratoNichoByResponsable($id_persona);
        $pagosPendientes = BoletaPago::totalPagosPendientesByResponsable($id_persona);
        $totalPagosPendientes = $pagosPendientes[0]->total ?? 0;

        return view('usuario.home', compact('persona', 'nichosDisponibles', 'misContratos', 'totalPagosPendientes'));
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
