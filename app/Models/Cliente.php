<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Esto es clave
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;
    // Definir los campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre', 'email', 'password', 'bloqueado',
    ];
    protected $casts = [
        'bloqueado' => 'boolean'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Si estás usando el campo "password", asegúrate de que se encripte antes de guardarse
    protected static function booted()
    {
        static::creating(function ($cliente) {
            if ($cliente->password) {
                $cliente->password = bcrypt($cliente->password);
            }
        });
    }
}

