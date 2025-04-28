<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Calle extends Model
{
    protected $table = 'calle'; 
    //
    public static function agregarCalle($nombre_calle){
        $success = DB::insert('INSERT INTO calle (nombre_calle) VALUES (?)', [$nombre_calle]);
        if ($success){
            return DB::getPdo()->lastInsertId();
        }else{
            return null;
        }
    }
}
