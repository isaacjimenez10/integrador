<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Cliente;
use Exception;

class ClienteLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:cliente')->except('logout', 'perfil', 'configuracion');
        $this->middleware('auth:cliente')->only('perfil', 'configuracion');
    }

    public function bloquear($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->bloqueado = !$cliente->bloqueado;
            $cliente->save();

            return redirect()->back()->with('success', 'El estado del cliente ha sido actualizado.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el estado del cliente.');
        }
    }
    
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:clientes,email,' . $cliente->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $cliente->update([
                'nombre' => $request->nombre,
                'email' => $request->email,
                ...(isset($request->password) ? ['password' => bcrypt($request->password)] : [])
            ]);

            return redirect()->route('admin.dashboard')
                           ->with('success', 'Cliente actualizado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al actualizar el cliente.')
                           ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();

            return redirect()->route('admin.dashboard')
                           ->with('success', 'Cliente eliminado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al eliminar el cliente.');
        }
    }

    public function showLoginForm()
    {
        return view('auth.cliente-login');
    }

    public function login(Request $request)
{
    // Verifica si los datos de la solicitud están llegando correctamente
    dd($request->all());

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->email;
    $attemptsKey = 'login_attempts_' . $email;
    $blockKey = 'login_block_' . $email;
    $maxAttempts = 3;

    // Verifica si la cuenta está bloqueada
    if (Cache::has($blockKey)) {
        $minutesLeft = Cache::get($blockKey)->diffInMinutes(now());
        return back()->with('error', "Demasiados intentos fallidos. Inténtalo de nuevo en $minutesLeft minutos.");
    }

    // Buscar el cliente por su email
    $cliente = Cliente::where('email', $email)->first();

    // Verificar si el cliente se encuentra en la base de datos
    Log::debug('Cliente encontrado: ', ['cliente' => $cliente]);

    // Verificar si el cliente fue encontrado y si la contraseña coincide
    if ($cliente) {
        // Verifica la contraseña en la base de datos
        Log::debug('Contraseña almacenada en base de datos:', ['password' => $cliente->password]);

        // Compara la contraseña del formulario con la almacenada en la base de datos
        if (\Hash::check($request->password, $cliente->password)) {
            Log::info('Credenciales correctas', ['cliente' => $cliente]);
            Auth::guard('cliente')->login($cliente);
            Cache::forget($attemptsKey);  // Restablecer los intentos fallidos
            $request->session()->regenerate();  // Regenerar la sesión
            session()->put('cliente_logged_in', true);  // Marcar al cliente como autenticado

            return redirect()->route('cliente.dashboard');  // Redirigir al dashboard
        } else {
            Log::error('Contraseña incorrecta', ['email' => $request->email]);
            return back()->with('error', 'Credenciales incorrectas');
        }
    } else {
        Log::error('Cliente no encontrado', ['email' => $request->email]);
        return back()->with('error', 'Credenciales incorrectas');
    }

   
}



    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    public function perfil()
    {
        return view('cliente.perfil', ['cliente' => Auth::guard('cliente')->user()]);
    }

    public function configuracion()
    {
        return view('cliente.configuracion', ['cliente' => Auth::guard('cliente')->user()]);
    }
}
