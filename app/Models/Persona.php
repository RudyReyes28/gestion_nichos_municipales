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
}
