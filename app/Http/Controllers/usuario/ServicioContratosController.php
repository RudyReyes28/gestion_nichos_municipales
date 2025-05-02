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

    public function renovarContrato($id_contrato)
    {
        if (!session()->has('id_autenticacion')) {
            return redirect()->route('login');
        }
        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];

        $contrato = ContratoNicho::getAllInfoContratoNichoById($id_contrato);
        $contrato = $contrato[0];
        return view('usuario.renovar_contrato', compact('persona', 'contrato'));
    }

    public function aceptarRenovacionContrato(Request $request)
    {
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

        $succes = ContratoNicho::renovarContrato($id_contrato, $ruta_boleta);
        if (!$succes) {
            return redirect()->route('usuario.servicio_contratos')->with('error', 'Error al renovar el contrato.');
        }
        return redirect()->route('usuario.servicio_contratos')->with('success', 'Contrato renovado correctamente.');
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
