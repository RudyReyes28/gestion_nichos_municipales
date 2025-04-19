<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;

class MiPerfilController extends Controller
{
    //
    public function index()
    {
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $informacion = Persona::getAllInfoPersonaById($id_persona);
        $informacion = $informacion[0];

        return view('usuario.mi_perfil', compact('persona', 'informacion'));
    }

}
