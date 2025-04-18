<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContratoNicho;
use App\Models\Nicho;
use App\Models\Ocupante;
use App\Models\Persona;
use App\Models\Avenida;

class ServicioNichosController extends Controller
{
    //
    public function manejoNichos(Request $request){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $nichos = Nicho::getAllInfoNichos();
        $avenidas = Avenida::allAvenida();
        $codigo = $request->query('codigo');      
        $ubicacion = $request->query('ubicacion'); 
        $estado = $request->query('estado');    
        if($codigo) {
            $nichos = Nicho::getAllInfoNichosId($codigo);
        } elseif ($ubicacion) {
            $nichos = Nicho::getAllInfoNichosByAvenida($ubicacion);
        } elseif ($estado) {
            $nichos = Nicho::getAllInfoNichosByEstado($estado);
        }

        return view('usuario.nichos', compact('persona', 'nichos', 'avenidas'));
        
    }

    public function solicitudContrato($id_nicho){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $causasMuerte = Ocupante::getAllTipoMuerte();
        $tiposOcupante = Ocupante::getAllTipoOcupante();


        return view('usuario.solicitud_contrato', compact('persona', 'id_nicho', 'causasMuerte', 'tiposOcupante'));
    }
    public function crearSolicitudContrato(Request $request){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_responsable = session()->get('id_persona');
        
        $id_nicho = $request->input('id_nicho');
        // datos del ocupante
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $dpi = $request->input('dpi');
        $id_persona = Persona::createPersona($nombre, $apellido, $dpi);
        $fecha_fallecimiento = $request->input('fecha_fallecimiento');
        $tipo_muerte = $request->input('tipo_muerte');
        $tipo_ocupante = $request->input('tipo_ocupante');
        if($id_persona){
            $id_ocupante = Ocupante::createOcupante($id_persona, $fecha_fallecimiento, $tipo_muerte, $tipo_ocupante);
            if($id_ocupante){
                $id_contrato = ContratoNicho::solicitarContrato($id_nicho, $id_ocupante, $id_responsable);
                if($id_contrato){
                    return redirect()->route('usuario.nichos')->with('success', 'Solicitud de contrato creada exitosamente');
                }else{
                    return redirect()->route('usuario.nichos')->with('error', 'Error al crear la solicitud de contrato');
                }
            }else{
                return redirect()->route('usuario.nichos')->with('error', 'Error al crear el ocupante');
            }
        }else{
            return redirect()->route('usuario.nichos')->with('error', 'Error al crear la persona');
        }
    }
}
