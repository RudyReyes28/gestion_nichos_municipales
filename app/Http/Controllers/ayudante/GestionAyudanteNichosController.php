<?php

namespace App\Http\Controllers\ayudante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nicho;
use App\Models\Persona;
use App\Models\UbicacionNicho;
use App\Models\TipoNicho;
use App\Models\Calle;
use App\Models\Avenida;
class GestionAyudanteNichosController extends Controller
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
        $nichos = Nicho::getViewNichos();
        $tipos_nicho = TipoNicho::getTipoNichos();

        return view('ayudante.gestion_nichos', compact('persona', 'nichos', 'tipos_nicho'));
    }

    public function crearNicho(Request $request){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        //obtenemos calle
        $nombre_calle = $request->input('nombre_calle');
        $id_calle = Calle::agregarCalle($nombre_calle);
        if($id_calle == null){
            return redirect()->route('ayudante.gestion_nichos')->with('error', 'Error al agregar la calle');
        }

        //obtenemos avenida
        $nombre_avenida = $request->input('nombre_avenida');
        $id_avenida = Avenida::agregarAvenida($nombre_avenida);
        if($id_avenida == null){
            return redirect()->route('ayudante.gestion_nichos')->with('error', 'Error al agregar la avenida');
        }

        //creamos la ubicacion
        $descripcion_ubicacion = $request->input('descripcion_ubicacion');
        $id_ubicacion = UbicacionNicho::agregarUbicacionNicho($id_calle, $id_avenida, $descripcion_ubicacion);
        if($id_ubicacion == null){
            return redirect()->route('ayudante.gestion_nichos')->with('error', 'Error al agregar la ubicacion');
        }
        //creamos el nicho
        $id_tipo_nicho = $request->input('tipo_nicho');
        $descripcion = $request->input('descripcion_nicho');
        $id_nicho = Nicho::createNicho($id_tipo_nicho, $id_ubicacion, $descripcion);
        if($id_nicho == null){
            return redirect()->route('ayudante.gestion_nichos')->with('error', 'Error al agregar el nicho');
        }else{
            return redirect()->route('ayudante.gestion_nichos')->with('success', 'Nicho creado correctamente');
        }

    }
}
