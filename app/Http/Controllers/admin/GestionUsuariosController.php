<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autenticacion;
use App\Models\ContratoNicho;
use App\Models\Ocupante;
use App\Models\TiposCausaMuerte;
use App\Models\TipoOcupante;
use App\Models\Municipio;
use App\Models\Departamento;
use App\Models\Persona;
class GestionUsuariosController extends Controller
{
    //
    public function index(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        //Obtener todos los ocupantes 
        $ocupantes = Ocupante::allOcupante();
        //Obtener todos los responsables
        $responsables = ContratoNicho::getResponsables();
        // obtener usuarios autenticados
        $usuarios = Autenticacion::allAutenticacion();

        return view('admin.gestion_usuarios', compact('persona', 'ocupantes', 'responsables', 'usuarios'));

    }

    public function gestionarOcupantes(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        
        //Obtener toda la informacion posible de los ocupantes
        $ocupantes = Ocupante::getOcupantesView();

        //Obtener tipo muerte
        $tipos_muerte = TiposCausaMuerte::allTiposCausaMuerte();
        //Obtener tipo ocupante
        $tipos_ocupante = TipoOcupante::allTipoOcupante();

        //obtener direccion-municipios con sus departamentos
        $municipios = Municipio::allMunicipioWithDepartamentos();
        //obtener todos los departamentos
        $departamentos = Departamento::allDepartamentos();

        return view('admin.gestion_ocupantes', compact('persona', 'ocupantes', 'tipos_muerte', 'tipos_ocupante', 'municipios', 'departamentos'));
    }

    public function editarOcupante(Request $request){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        //dd($request->all());

        //editar persona
        $id_persona = $request->input('id_persona');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $dpi = $request->input('dpi');
        $success = Persona::updatePersona($id_persona, $nombre, $apellido, $dpi);

        //editar contacto persona
        $id_contacto = $request->input('id_contacto');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');
        $id_direccion = $request->input('id_direccion');
        $id_municipio = $request->input('id_municipio');
        $descripcion_direccion = $request->input('descripcion_direccion');
        if($id_direccion != null){
            $success = Persona::updateDireccionPersona($id_direccion, $id_municipio, $descripcion_direccion);
        }else{
            if($id_persona != null && $id_municipio != null){
                $id_direccion = Persona::createDireccionPersona( $id_municipio, $descripcion_direccion);
            }
        }

        if($id_contacto != null ){
            $success = Persona::updateContactoPersona($id_contacto, $telefono, $correo, $id_direccion);
        }else{
            
            if($id_persona != null && $id_direccion != null){
                $creado = Persona::createContactoPersona($id_persona, $telefono, $correo, $id_direccion);
                if($creado){
                    $success =+1;
                }
            }
                
        }

        //editar ocupante
        $id_ocupante = $request->input('id_ocupante');
        $fecha_fallecimiento = $request->input('fecha_fallecimiento');
        $id_tipo_muerte = $request->input('id_tipo_muerte');
        $id_tipo_ocupante = $request->input('id_tipo_ocupante');
        $success= Ocupante::updateOcupante($id_ocupante, $id_persona, $fecha_fallecimiento, $id_tipo_muerte, $id_tipo_ocupante);

        
        return redirect()->route('admin.gestion_ocupantes')->with('success', 'Ocupante editado correctamente');
        

    }

    public function gestionarResponsables(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        
        $responsables = ContratoNicho::getAllInfoResponsables();

        //obtener direccion-municipios con sus departamentos
        $municipios = Municipio::allMunicipioWithDepartamentos();

        //obtener todos los departamentos
        $departamentos = Departamento::allDepartamentos();

        return view('admin.gestion_responsables', compact('persona', 'responsables', 'municipios', 'departamentos'));

    }

    public function editarResponsable(Request $request){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        //dd($request->all());


        //editar persona
        $id_persona = $request->input('id_persona');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $dpi = $request->input('dpi');
        $success = Persona::updatePersona($id_persona, $nombre, $apellido, $dpi);

        //editar contacto persona
        $id_contacto = $request->input('id_contacto');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');
        $id_direccion = $request->input('id_direccion');
        $id_municipio = $request->input('id_municipio');
        $descripcion_direccion = $request->input('descripcion_direccion');
        if($id_direccion != null){
            $success += Persona::updateDireccionPersona($id_direccion, $id_municipio, $descripcion_direccion);
        }else{
            if($id_persona != null && $id_municipio != null){
                $id_direccion = Persona::createDireccionPersona( $id_municipio, $descripcion_direccion);
            }
        }

        if($id_contacto != null ){
            $success+= Persona::updateContactoPersona($id_contacto, $telefono, $correo, $id_direccion);
        }else{
            
            if($id_persona != null && $id_direccion != null){
                $creado = Persona::createContactoPersona($id_persona, $telefono, $correo, $id_direccion);
                if($creado){
                    $success+=1;
                }
            }
                
        }
        
        if($success){
            return redirect()->route('admin.gestion_responsables')->with('success', 'Responsable editado correctamente');
        }else{
            return redirect()->route('admin.gestion_responsables')->with('error', 'Error al editar el responsable');
        }

    }

    public function gestionarUsuariosAutenticados(){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $id_autenticacion = session()->get('id_autenticacion');
        $id_persona = session()->get('id_persona');
        $persona = Persona::getPersonaById($id_persona);
        $persona = $persona[0];
        
        //obtener todos los usuarios autenticados
        $usuarios = Autenticacion::getAllInfoAutenticacion();

        //obtener todos los tipos de usuario
        $tipos_usuario = Autenticacion::getTiposUsuario();

        //obtener municipios con departamentos
        $municipios = Municipio::allMunicipioWithDepartamentos();

        //obtener todos los departamentos
        $departamentos = Departamento::allDepartamentos();

        return view('admin.gestion_usuarios_autenticados', compact('persona', 'usuarios', 'tipos_usuario', 'municipios', 'departamentos'));
    }

    public function activarUsuario($id_usuario){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }


        $success = Autenticacion::activarUsuario($id_usuario);

        if($success){
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('success', 'Usuario activado correctamente');
        }else{
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('error', 'Error al activar el usuario');
        }
    }

    public function eliminarUsuario($id_usuario){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }

        $success = Autenticacion::desactivarUsuario($id_usuario);

        if($success){
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('success', 'Usuario eliminado correctamente');
        }else{
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('error', 'Error al eliminar el usuario');
        }
    }

    public function crearUsuario(Request $request){
        if(!session()->has('id_autenticacion')){
            return redirect()->route('login');
        }
        //dd($request->all());
        //crear persona
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $dpi = $request->input('dpi');
        $id_persona = Persona::createPersona($nombre, $apellido, $dpi);

        //crear direccion persona
        $id_municipio = $request->input('id_municipio');
        $descripcion_direccion = $request->input('descripcion_direccion');
        $id_direccion = Persona::createDireccionPersona($id_municipio, $descripcion_direccion);
        //crear contacto persona
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');
        
        if($id_persona){
            Persona::createContactoPersona($id_persona, $telefono, $correo, $id_direccion);
        }else{
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('error', 'Error al crear el usuario');
        }

        //crear usuario autenticado
        $usuario = $request->input('usuario');
        $contrasenia = $request->input('contrasenia');
        $id_tipo_usuario = $request->input('id_tipo_usuario');
        
        $success = Autenticacion::createAutenticacion($id_persona, $id_tipo_usuario, $usuario, $contrasenia);
      
        if($success){
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('success', 'Usuario creado correctamente');
        }else{
            return redirect()->route('admin.gestion_usuarios_autenticados')->with('error', 'Error al crear el usuario');
        }
    }

}
