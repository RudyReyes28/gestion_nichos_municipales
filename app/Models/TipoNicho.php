<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNicho extends Model
{
    protected $table = 'tipo_nicho';
    //
    public static function getTipoNichos()
    {
        return TipoNicho::all();
    }
}
