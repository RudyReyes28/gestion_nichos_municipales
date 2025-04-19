<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nicho;
use App\Models\Persona;
use App\Models\ContratoNicho;
class MisNichosController extends Controller
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
        $informacion = ContratoNicho::getAllInfoContratoNichoByResponsableAndEstado($id_persona, 'activo');

        return view('usuario.mis_nichos', compact('persona', 'informacion'));
    }
}
