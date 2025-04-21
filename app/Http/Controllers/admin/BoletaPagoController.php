<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoletaPago;
use App\Models\Persona;

class BoletaPagoController extends Controller
{
    //

    public function index(){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $boletas = BoletaPago::getAllInfoContratoBoletas();
        return view('admin.boleta_pago', compact('persona', 'boletas'));

    }

    public function aceptarPagoBoleta($id_boleta){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $succes = BoletaPago::procesarPagoBoleta($id_boleta);
        if ($succes) {
            return redirect()->route('admin.boleta_pago')->with('success', 'Pago procesado correctamente');
        } else {
            return redirect()->route('admin.boleta_pago')->with('error', 'Error al procesar el pago');
        }
    }
}
