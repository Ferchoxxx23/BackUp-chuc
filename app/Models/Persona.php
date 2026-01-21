<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Nombre de la tabla en tu base de datos
    protected $table = 'persona';
    

    // Tu llave primaria no es "id", es "IdPersona"
protected $primaryKey = 'IdPersona';
    // Desactivamos timestamps si tu tabla no tiene created_at/updated_at
    public $timestamps = false;

    // Campos que permitimos insertar
    protected $fillable = [
        'Nombre', 
        'Apellido', 
        'Direccion', 
        'Localidad'
    ];
}