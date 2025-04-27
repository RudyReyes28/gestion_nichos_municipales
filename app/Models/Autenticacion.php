<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Autenticacion extends Model
{
    protected $table = 'autenticacion';
    //
    public static function allAutenticacion()
    {
        return DB::select('SELECT * FROM autenticacion ');
    }

    public static function getAutenticacion($id)
    {
        return DB::select('SELECT * FROM autenticacion WHERE id = ?', [$id]);
    }

    public static function getAutenticacionByUsuario($usuario)
    {
        return DB::select('SELECT * FROM autenticacion WHERE usuario = ?', [$usuario]);
    }

    public static function createAutenticacion($id_persona, $id_tipo_usuario, $usuario, $contrasenia)
    {
        $estado = 'activo';
        return DB::insert('INSERT INTO autenticacion (id_persona, id_tipo_usuario, usuario, contrasenia, estado) VALUES (?, ?, ?, ?, ?)', [$id_persona, $id_tipo_usuario, $usuario, bcrypt($contrasenia), $estado]);
    }

    public static function updateAutenticacion($id, $id_persona, $id_tipo_usuario, $usuario, $contrasenia)
    {
        return DB::update('UPDATE autenticacion SET id_persona = ?, id_tipo_usuario = ?, usuario = ?, contrasenia = ? WHERE id_autenticacion = ?', [$id_persona, $id_tipo_usuario, $usuario, bcrypt($contrasenia), $id]);
    }
    public static function deleteAutenticacion($id)
    {
        return DB::delete('DELETE FROM autenticacion WHERE id_autenticacion = ?', [$id]);
    }

    public static function getAllInfoAutenticacion()
    {
        return DB::select('SELECT * FROM vista_usuarios_autenticados');
    }

    public static function getTiposUsuario(){
        return DB::select('SELECT * FROM tipo_usuario');
    }

    public static function activiarUsuario($id_autenticacion){
        return DB::update('UPDATE autenticacion SET estado = ? WHERE id_autenticacion = ?', ['activo', $id_autenticacion]);
    }

    public static function desactivarUsuario($id_autenticacion){
        return DB::update('UPDATE autenticacion SET estado = ? WHERE id_autenticacion = ?', ['inactivo', $id_autenticacion]);
    }

}
