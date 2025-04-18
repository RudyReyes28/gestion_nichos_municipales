<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ocupante extends Model
{
    protected $table = 'ocupante';
    //
    
    public static function allOcupante()
    {
        return DB::select('SELECT * FROM ocupante');
    }

    public static function createOcupante($id_persona, $fecha_fallecimiento, $id_tipo_muerte, $id_tipo_ocupante)
    {
        $succes = DB::insert('INSERT INTO ocupante (id_persona, fecha_fallecimiento, id_tipo_muerte, id_tipo_ocupante) VALUES (?, ?, ?, ?)', [$id_persona, $fecha_fallecimiento, $id_tipo_muerte, $id_tipo_ocupante]);
        if ($succes) {
            return DB::getPdo()->lastInsertId();
        } else {
            return null;
        }
    }

    public static function getAllTipoMuerte()
    {
        return DB::select('SELECT * FROM tipos_causa_muerte');
    }
    public static function getAllTipoOcupante()
    {
        return DB::select('SELECT * FROM tipo_ocupante');
    }
    public static function updateOcupante($id_ocupante, $id_persona, $fecha_fallecimiento, $id_tipo_muerte, $id_tipo_ocupante)
    {
        return DB::update('UPDATE ocupante SET id_persona = ?, fecha_fallecimiento = ?, id_tipo_muerte = ?, id_tipo_ocupante = ? WHERE id_ocupante = ?', [$id_persona, $fecha_fallecimiento, $id_tipo_muerte, $id_tipo_ocupante, $id_ocupante]);
    }
    public static function deleteOcupante($id_ocupante)
    {
        return DB::delete('DELETE FROM ocupante WHERE id_ocupante = ?', [$id_ocupante]);
    }
    public static function getOcupanteById($id_ocupante)
    {
        return DB::select('SELECT * FROM ocupante WHERE id_ocupante = ?', [$id_ocupante]);
    }

    public static function getAllInformationOcupantes()
    {
        return DB::select('SELECT oc.*, p.nombre, p.apellido, p.dpi, tm.nombre_causa, toc.tipo FROM ocupante oc
        JOIN persona p ON oc.id_persona = p.id_persona
        JOIN tipos_causa_muerte tm ON oc.id_tipo_muerte = tm.id_tipo_muerte
        JOIN tipo_ocupante toc ON oc.id_tipo_ocupante = toc.id_tipo_ocupante');
    }

}
