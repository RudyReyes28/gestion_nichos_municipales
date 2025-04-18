<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';
    //

    public static function getPersonaById($id_persona)
    {
        return DB::table('persona')
            ->where('id_persona', $id_persona)
            ->get();
    }

    public static function allPersona()
    {
        return DB::select('SELECT * FROM persona');
    }
    public static function createPersona($nombre, $apellido, $dpi)
    {
        $succes = DB::insert('INSERT INTO persona (nombre, apellido, dpi) VALUES (?, ?, ?)', [$nombre, $apellido, $dpi]);
        if ($succes){
            return DB::getPdo()->lastInsertId();
        }else{
            return null;
        }
    
    }
    public static function updatePersona($id_persona, $nombre, $apellido, $dpi)
    {
        return DB::update('UPDATE persona SET nombre = ?, apellido = ?, dpi = ? WHERE id_persona = ?', [$nombre, $apellido, $dpi, $id_persona]);
    }
    public static function deletePersona($id_persona)
    {
        return DB::delete('DELETE FROM persona WHERE id_persona = ?', [$id_persona]);
    }
    public static function getPersonaByDPI($dpi)
    {
        return DB::select('SELECT * FROM persona WHERE dpi = ?', [$dpi]);
    }


    public static function createContactoPersona($id_persona, $telefono, $correo, $id_direccion)
    {
        $succes = DB::insert('INSERT INTO contacto_persona (id_persona, telefono, correo, id_direccion) VALUES (?, ?, ?, ?)', [$id_persona, $telefono, $correo, $id_direccion]);
        if ($succes){
            return DB::getPdo()->lastInsertId();
        }else{
            return null;
        }
    }
    public static function updateContactoPersona($id_contacto, $telefono, $correo, $id_direccion)
    {
        return DB::update('UPDATE contacto_persona SET telefono = ?, correo = ?, id_direccion = ? WHERE id_contacto = ?', [$telefono, $correo, $id_direccion, $id_contacto]);
    }
    public static function deleteContactoPersona($id_contacto)
    {
        return DB::delete('DELETE FROM contacto_persona WHERE id_contacto = ?', [$id_contacto]);
    }
    public static function getContactoPersona($id_contacto)
    {
        return DB::select('SELECT * FROM contacto_persona WHERE id_contacto = ?', [$id_contacto]);
    }
    public static function getContactoPersonaByIdPersona($id_persona)
    {
        return DB::select('SELECT * FROM contacto_persona WHERE id_persona = ?', [$id_persona]);
    }
}
