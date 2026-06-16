<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios'; // Tabla real en tu DB
    public $timestamps = false;    // Desactivado si no tienes created_at/updated_at

    protected $fillable = [
        'nombre', 'apellido', 'correo', 'usuario', 'contrasena',
    ];

    // Ocultar campos sensibles al convertir a JSON
    protected $hidden = [
        'contrasena',
    ];
}