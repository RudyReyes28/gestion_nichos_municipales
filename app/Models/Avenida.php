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
    //
}
