<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Cliente; // Importa el modelo Cliente
use Illuminate\Support\Facades\DB; // Importa DB para las consultas raw
use Carbon\Carbon; // Importa Carbon para el manejo de fechas
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientesImport;

class AdminLoginController extends Controller
{
    public function bloquear($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->bloqueado = !$cliente->bloqueado; // Cambia el estado de bloqueado
        $cliente->save();

        return redirect()->back()->with('success', 'El estado del cliente ha sido actualizado.');
    }
    
    public function dashboard()
    {
        // Obtener clientes paginados
        $clientes = Cliente::paginate(10); // Cambia 10 por el número de clientes que deseas mostrar por página

        // Obtener los registros por mes (número de clientes por mes)
        $registrosPorMes = Cliente::selectRaw('MONTH(created_at) as mes, COUNT(*) as cantidad')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('mes', 'asc')
            ->pluck('cantidad'); // Obtiene solo las cantidades

        // Obtener los nombres de los meses para las etiquetas
        $meses = [ 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        // Pasar los clientes y los registros por mes a la vista
        return view('admin.dashboard', compact('clientes', 'registrosPorMes', 'meses'));
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $email = $request->email;
        $attemptsKey = 'login_attempts_admin_' . $email;
        $blockKey = 'login_block_admin_' . $email;

        if (Cache::has($blockKey)) {
            return back()->withErrors(['email' => '⛔ Demasiados intentos. Inténtelo en 3 minutos.']);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            Cache::forget($attemptsKey);
            return redirect()->route('admin.dashboard');
        }

        Cache::increment($attemptsKey);
        if (Cache::get($attemptsKey) >= 3) {
            Cache::put($blockKey, true, now()->addMinutes(3));
            Cache::forget($attemptsKey);
            return back()->withErrors(['email' => '⛔ Demasiados intentos. Inténtelo en 3 minutos.']);
        }

        return back()->withErrors(['email' => '⚠️ Credenciales incorrectas']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Usar la clase ClientesImport para manejar la importación
        Excel::import(new ClientesImport, $request->file('file'));

        return redirect()->back()->with('success', 'Clientes importados exitosamente.');
    }
}