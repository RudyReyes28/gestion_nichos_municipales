<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

    //
    public static function allDepartamentos(){
        return Departamento::all();
    }
}
