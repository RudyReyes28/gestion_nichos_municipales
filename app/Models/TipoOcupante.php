<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoOcupante extends Model
{
    protected $table = 'tipo_ocupante';
    //

    public static function allTipoOcupante()
    {
        return DB::select('SELECT * FROM tipo_ocupante');
    }   
}
