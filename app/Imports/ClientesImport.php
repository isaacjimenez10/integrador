<?php

namespace App\Imports;

use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Cliente([
            'nombre'    => $row['nombre'],
            'email'     => $row['email'],
            'password'  => Hash::make($row['password']), // Hashear contraseña
            'bloqueado' => filter_var($row['bloqueado'], FILTER_VALIDATE_BOOLEAN), // Convertir a booleano
        ]);
        Log::info('Datos importados: ', $row);  
    }
}
