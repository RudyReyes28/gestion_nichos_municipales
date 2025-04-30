<?php

namespace App\Http\Controllers\ayudante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContratoNicho;
use App\Models\Nicho;
use App\Models\Ocupante;
use App\Models\Persona;
use App\Models\BoletaPago;
class GestionAyudanteContratosController extends Controller
{
    //
    public function contratos(request $request){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $contratos = ContratoNicho::getAllInfoContratoNicho();
        $estado = $request->query('estado');
        if($estado) {
            $contratos = ContratoNicho::getAllInfoContratoNichoByEstado($estado);
        }
        return view('ayudante.contratos', compact('persona', 'contratos'));
        
    }

    public function rechazarContrato($id_contrato){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $succes = ContratoNicho::rechazarContrato($id_contrato);
        if (!$succes) {
            return redirect()->route('ayudante.contratos')->with('error', 'Error al rechazar el contrato.');
        }

        return redirect()->route('ayudante.contratos')->with('success', 'Contrato rechazado correctamente.');
    }

    public function generarBoleta($id_contrato){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $contrato = ContratoNicho::getAllInfoContratoNichoById($id_contrato);
        $contrato = $contrato[0];
        return view('ayudante.generar_boleta', compact('persona', 'contrato'));
    }

    public function aceptarContrato(Request $request){
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        $id_contrato = $request->input('id_contrato');
        $ruta_boleta = $request->input('ruta_boleta');
        $imagen_boleta = $request->input('imagen_boleta');
        // LOGICA PARA CREAR LA BOLETA  JPG Y GUARDARLA, GENERAR LA RUTA 
        $this->guardarImagenBoleta($imagen_boleta, $ruta_boleta);

        $succes = ContratoNicho::aceptarContrato($id_contrato);
        if (!$succes) {
            return redirect()->route('ayudante.contratos')->with('error', 'Error al aceptar el contrato.');
        }
        $succes = BoletaPago::generarBoleta($id_contrato, $ruta_boleta);
        if (!$succes) {
            return redirect()->route('ayudante.contratos')->with('error', 'Error al generar la boleta.');
        }
        return redirect()->route('ayudante.contratos')->with('success', 'Boleta generada correctamente.');
    }


    /**
     * Guarda la imagen de la boleta en el almacenamiento
     * 
     * @param string $imgBase64
     * @param string $ruta
     * @return bool
     */
    private function guardarImagenBoleta($imgBase64, $ruta)
    {
        // Extraer el contenido base64 sin la cabecera
        $imgBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $imgBase64);
        $imgBase64 = str_replace(' ', '+', $imgBase64);

        // Decodificar la imagen base64
        $imgBinary = base64_decode($imgBase64);

        // Crear la estructura de directorios si no existe
        $directorio = public_path('storage/boletas');
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // Extraer nombre de archivo de la ruta
        $nombreArchivo = basename($ruta);

        // Guardar la imagen en el servidor
        $rutaCompleta = $directorio . '/' . $nombreArchivo;
        file_put_contents($rutaCompleta, $imgBinary);

        return true;
    }
}
