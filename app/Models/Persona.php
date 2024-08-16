<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Nombre de la tabla
    protected $table = 'personas';

    // Nombre de la clave primaria
    protected $primaryKey = 'nPerCodigo';
    //protected $guarded=[];
    protected $fillable = ['cPerApellido','cPerNombre','cPerDireccion','dPerFecNac','nPerEdad','nPerSueldo','cPerRnd','nPerEstado'];
}
