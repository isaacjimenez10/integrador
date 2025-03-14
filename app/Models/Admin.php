<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Cambia Model por Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable // <-- Ahora extiende Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins'; // Asegúrate de que el nombre coincida con la tabla en la BD

    protected $fillable = ['nombre', 'email', 'password'];
}


