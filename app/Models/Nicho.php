<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nicho extends Model
{
    
    //
    public static function allNicho()
    {
        return DB::select('SELECT * FROM nichos');
    }
    public static function getNicho($id)
    {
        return DB::select('SELECT * FROM nichos WHERE id_nicho = ?', [$id]);
    }
    
    public static function createNicho($id_tipo_nicho, $id_ubicacion_nicho, $descripcion)
    {
        $estado = 'disponible';
        $succes = DB::insert('INSERT INTO nichos (id_tipo_nicho, id_ubicacion_nicho, descripcion, estado) VALUES (?, ?, ?, ?)', [$id_tipo_nicho, $id_ubicacion_nicho, $descripcion, $estado]);
        if($succes){
            return DB::getPdo()->lastInsertId();
        }else{
            return null;
        }
    
    }
    public static function updateNicho($id, $id_tipo_nicho, $id_ubicacion_nicho, $descripcion, $estado)
    {
        return DB::update('UPDATE nichos SET id_tipo_nicho = ?, id_ubicacion_nicho = ?, descripcion = ?, estado = ? WHERE id_nicho = ?', [$id_tipo_nicho, $id_ubicacion_nicho, $descripcion, $estado, $id]);
    }
    public static function deleteNicho($id)
    {
        return DB::delete('DELETE FROM nichos WHERE id_nicho = ?', [$id]);
    }
    public static function getNichoByUbicacion($id_ubicacion_nicho)
    {
        return DB::select('SELECT * FROM nichos WHERE id_ubicacion_nicho = ?', [$id_ubicacion_nicho]);
    }
    public static function getNichoByTipo($id_tipo_nicho)
    {
        return DB::select('SELECT * FROM nichos WHERE id_tipo_nicho = ?', [$id_tipo_nicho]);
    }
    public static function getNichoByEstado($estado)
    {
        return DB::select('SELECT * FROM nichos WHERE estado = ?', [$estado]);
    }


    public static function getAllInfoNichos()
    {
        return DB::select('SELECT n.*,  av.nombre_avenida, c.nombre_calle, tn.nombre_tipo 
        FROM nichos n
        JOIN ubicacion_nicho un ON n.id_ubicacion_nicho = un.id_ubicacion_nicho
        JOIN avenida av ON un.id_avenida = av.id_avenida
        JOIN calle c ON un.id_calle = c.id_calle
        JOIN tipo_nicho tn ON n.id_tipo_nicho = tn.id_tipo_nicho');
    }

}
