<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Auditoria;
use App\Models\ContratoNicho;

class AuditarController extends Controller
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

        $auditorias = Auditoria::getAuditoriasByIdPersona($id_persona);
        $contratos = ContratoNicho::getAllInfoContratoNicho();
        return view('auditoria.auditar', compact('persona', 'auditorias', 'contratos'));
    }

    public function crearAuditoria(Request $request)
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        $id_contrato = $request->input('id_contrato');
        $tipo_problema = $request->input('tipo_problema');
        $id_auditor = $persona->id_persona;
        $detalles_auditoria = $request->input('detalles_auditoria');

        $succes = Auditoria::crearAuditoria($id_contrato, $tipo_problema, $id_auditor, $detalles_auditoria);
        if (!$succes) {
            return redirect()->route('auditoria.auditar')->with('error', 'Error al crear la auditoría.');
        }

        return redirect()->route('auditoria.auditar')->with('success', 'Auditoría creada exitosamente.');
    }

    public function verTodasLasAuditorias()
    {
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        $auditorias = Auditoria::getAuditorias();
        return view('auditoria.ver_auditorias', compact('persona', 'auditorias'));
    }
}
