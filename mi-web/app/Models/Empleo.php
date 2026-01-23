<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $table = 'empleo';

    // Llave primaria según tu imagen
    protected $primaryKey = 'IdEmpleo';
    public $timestamps = false;

    // Campos para insertar
    protected $fillable = [
        'Descripcion', 
        'Turno'
    ];
}