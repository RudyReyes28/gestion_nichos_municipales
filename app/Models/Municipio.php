<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Municipio extends Model
{
    protected $table = 'municipio';
    //

    public static function allMunicipioWithDepartamentos()
    {
        return DB::select('SELECT m.id_municipio, m.nombre as nombre_municipio, d.id_departamento, d.nombre as nombre_departamento FROM municipio m INNER JOIN departamento d ON m.id_departamento = d.id_departamento');
    }
}
