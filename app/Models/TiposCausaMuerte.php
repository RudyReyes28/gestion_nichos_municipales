<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TiposCausaMuerte extends Model
{
    protected $table = 'tipos_causa_muerte';
    //
    public static function allTiposCausaMuerte()
    {
        return DB::select('SELECT * FROM tipos_causa_muerte');
    }
}
