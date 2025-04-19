<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContratoNicho;
use App\Models\Nicho;
use App\Models\Persona;
use App\Models\BoletaPago;

class ServicioContratosController extends Controller
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
        $servicioContratos = ContratoNicho::getAllInfoContratoNichoByResponsable($id_persona);
        $boletas = BoletaPago::getAllBoletas();

        return view('usuario.servicio_contratos', compact('persona', 'servicioContratos', 'boletas'));
        
    }

    public function pagarBoleta($id_boleta)
    {
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $succes = BoletaPago::pagoBoleta($id_boleta);
        $id_contrato = BoletaPago::getIdContratoByBoleta($id_boleta);
        $id_contrato = $id_contrato[0]->id_contrato;
        ContratoNicho::updateEstadoPagoBoleta($id_contrato);
        if ($succes) {
            return redirect()->route('usuario.servicio_contratos')->with('success', 'Pago realizado con éxito');
        } else {
            return redirect()->route('usuario.servicio_contratos')->with('error', 'Error al realizar el pago');
        }
    }
}
