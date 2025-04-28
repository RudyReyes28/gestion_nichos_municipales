<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Avenida extends Model
{
    protected $table = 'avenida';

    public static function allAvenida()
    {
        return DB::select('SELECT * FROM avenida');
    }

    public static function agregarAvenida($nombre_avenida)
    {
        $succes = DB::insert('INSERT INTO avenida (nombre_avenida) VALUES (?)', [$nombre_avenida]);
        if ($succes) {
            return DB::getPdo()->lastInsertId();
        } else {
            return null;
        }
    }
    //
}
