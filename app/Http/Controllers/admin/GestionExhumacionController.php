<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistroExhumaciones;
use App\Models\Persona;

class GestionExhumacionController extends Controller
{
    //
    public function index(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $exhumacionesPendientes = RegistroExhumaciones::getAllInfoExhumacionesByEstado('solicitado');
        return view ('admin.gestion_exhumacion', compact('persona','exhumacionesPendientes'));
    }

    public function verTodasExhumaciones(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $exhumaciones = RegistroExhumaciones::getAllInfoExhumaciones();
        return view ('admin.ver_exhumaciones', compact('persona','exhumaciones'));
    }

    public function aceptarExhumacion($id_exhumacion){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $succes = RegistroExhumaciones::aceptarExhumacion($id_exhumacion);
        if($succes){
            return redirect()->route('admin.gestion_exhumacion')->with('success', 'Exhumación aceptada correctamente');
        }else{
            return redirect()->route('admin.gestion_exhumacion')->with('error', 'Error al aceptar la exhumación');
        }

        
    }

    public function rechazarExhumacion($id_exhumacion){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $succes = RegistroExhumaciones::rechazarExhumacion($id_exhumacion);
        if($succes){
            return redirect()->route('admin.gestion_exhumacion')->with('success', 'Exhumación rechazada correctamente');
        }else{
            return redirect()->route('admin.gestion_exhumacion')->with('error', 'Error al rechazar la exhumación');
        }
    }
}
