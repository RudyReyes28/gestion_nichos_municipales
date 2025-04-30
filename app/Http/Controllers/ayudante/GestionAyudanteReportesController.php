<?php

namespace App\Http\Controllers\ayudante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class GestionAyudanteReportesController extends Controller
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

        //todos los datos de los reportes

        return view('ayudante.reportes', compact('persona'));
    }
}
