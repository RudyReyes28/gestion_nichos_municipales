<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UbicacionNicho extends Model
{
    protected $table = 'ubicacion_nicho';
    //

    public static function agregarUbicacionNicho($id_calle, $id_avenida, $descripcion){
        $success = DB::insert('INSERT INTO ubicacion_nicho (id_calle, id_avenida, descripcion) VALUES (?, ?, ?)', [$id_calle, $id_avenida, $descripcion]);
        if($success){
            return DB::getPdo()->lastInsertId();
        }else{
            return null;
        }
    }
}
