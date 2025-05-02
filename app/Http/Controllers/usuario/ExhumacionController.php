<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistroExhumaciones;
use App\Models\ContratoNicho;
use App\Models\Persona;

class ExhumacionController extends Controller
{
    //
    public function index()
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $misContratos= ContratoNicho::getAllInfoContratoNichoForExhumacionByResponsable($id_persona);
        $misExhumaciones= RegistroExhumaciones::getAllInfoExhumacionesByIdPersona($id_persona);
        $idExhumacionesContrato = [];
        foreach ($misExhumaciones as $exhumacion) {
            $idExhumacionesContrato[] = $exhumacion->id_contrato;
        }
        return view('usuario.exhumacion', compact('persona','misContratos','idExhumacionesContrato'));

    }

    public function registrarExhumacion(Request $request)
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $nombre = $persona->nombre;
        $id_contrato = $request->input('id_contrato');
        $fecha_exhumacion = $request->input('fecha_exhumacion');
        $motivo = $request->input('motivo');

        $succes = RegistroExhumaciones::registrarExhumacion($id_contrato, $fecha_exhumacion, $motivo, $id_persona, $nombre);

        if ($succes) {
            return redirect()->route('usuario.exhumacion')->with('success', 'Exhumación registrada exitosamente.');
        } else {
            return redirect()->route('usuario.exhumacion')->with('error', 'Error al registrar la exhumación.');
        }
    }

    public function misExhumaciones()
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $misExhumaciones= RegistroExhumaciones::getAllInfoExhumacionesByIdPersona($id_persona);
        return view('usuario.misExhumaciones', compact('persona','misExhumaciones'));
    }
}
