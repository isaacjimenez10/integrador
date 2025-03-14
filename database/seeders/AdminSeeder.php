<?php
namespace Database\Seeders; // << Asegúrate de que esta línea esté bien

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate( // << Cambiado de Create() a updateOrCreate()
            ['email' => 'admin@correo.com'], 
            [
                'nombre' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
