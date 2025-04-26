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
        return view ('admin.gestionExhumacion', compact('persona','exhumacionesPendientes'));

    }
}
