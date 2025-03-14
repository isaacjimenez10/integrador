<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClienteRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.cliente-register');
    }

    public function register(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:255',
                'min:2', // Asegúrate de que el nombre tenga al menos 2 caracteres
                'regex:/^[a-zA-Z\s]+$/', // Solo letras y espacios
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:clientes',
                // Se puede omitir la regex, ya que 'email' ya valida el formato
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'confirmed',
                'regex:/[A-Z]/', // Al menos una mayúscula
                'regex:/[a-z]/', // Al menos una minúscula
                'regex:/[0-9]/', // Al menos un número
                'regex:/[\W_]/', // Al menos un carácter especial
                'not_in:12345678,abcdefgh,ABCDEFGH', // Ejemplo de contraseñas comunes a evitar
            ],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.not_in' => 'La contraseña es demasiado común. Por favor elige otra.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el cliente en la base de datos
        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Iniciar sesión automáticamente después del registro
        auth()->guard('cliente')->login($cliente);

        return redirect()->route('cliente.dashboard')->with('success', 'Registro exitoso');
    }
}