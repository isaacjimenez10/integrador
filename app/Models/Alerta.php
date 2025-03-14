<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';
    protected $fillable = ['sensor_id', 'tipo_alerta', 'descripcion', 'fecha_hora', 'estado'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}

