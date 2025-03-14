<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ImportacionController;
use App\Http\Controllers\LecturaController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ClienteRegisterController;

// Registro de clientes
Route::get('cliente/register', [ClienteRegisterController::class, 'showRegistrationForm'])->name('cliente.register');
Route::post('cliente/register', [ClienteRegisterController::class, 'register']);

// Login Cliente
Route::get('cliente/login', [ClienteLoginController::class, 'showLoginForm'])->name('cliente.login');
Route::post('cliente/login', [ClienteLoginController::class, 'login']);
Route::post('cliente/logout', [ClienteLoginController::class, 'logout'])->name('cliente.logout');

// Dashboard Cliente
Route::get('cliente/dashboard', function () {
    return view('cliente.dashboard');
})->middleware('auth:cliente')->name('cliente.dashboard');
Route::get('/cliente/perfil', [ClienteLoginController::class, 'perfil'])->name('cliente.perfil');
Route::get('/cliente/configuracion', [ClienteLoginController::class, 'configuracion'])->name('cliente.configuracion');
Route::post('/clientes/importar', [ClienteLoginController::class, 'importar'])->name('clientes.importar');
// Login Admin
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login']);
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::post('/importar-clientes', [ImportacionController::class, 'import'])->name('admin.import');

// Dashboard Admin
Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth:admin')->name('admin.dashboard');
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
    // Listar todos los clientes
Route::get('clientes', [ClienteLoginController::class, 'index'])->name('clientes.index');

// Mostrar formulario para crear un nuevo cliente
Route::get('clientes/create', [ClienteLoginController::class, 'create'])->name('clientes.create');

// Guardar un nuevo cliente
Route::post('clientes', [ClienteLoginController::class, 'store'])->name('clientes.store');

// Mostrar formulario para editar un cliente existente
Route::get('clientes/{cliente}/edit', [ClienteLoginController::class, 'edit'])->name('clientes.edit');

// Actualizar un cliente existente
Route::put('clientes/{cliente}', [ClienteLoginController::class, 'update'])->name('clientes.update');

// Eliminar un cliente
Route::delete('clientes/{cliente}', [ClienteLoginController::class, 'destroy'])->name('clientes.destroy');
});

Route::post('clientes/{id}/bloquear', [ClienteLoginController::class, 'bloquear'])->name('clientes.bloquear');
Route::post('/clientes/importar', [ClienteLoginController::class, 'importar'])->name('clientes.importar');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/mision', function () {
    return view('mision');
});
Route::get('/vision', function () {
    return view('vision');
});
Route::get('/objetivos', function () {
    return view('objetivos');
});
Route::get('/nosotros', function () {
    return view('nosotros');
});

// Rutas CRUD completas para Sensor
Route::get('sensores', [SensorController::class, 'index'])->name('sensores.index');
Route::get('sensores/create', [SensorController::class, 'create'])->name('sensores.create');
Route::post('sensores', [SensorController::class, 'store'])->name('sensores.store');
Route::get('sensores/{id}', [SensorController::class, 'show'])->name('sensores.show'); 
Route::get('sensores/{id}/edit', [SensorController::class, 'edit'])->name('sensores.edit'); 
Route::put('sensores/{id}', [SensorController::class, 'update'])->name('sensores.update'); 
Route::delete('sensores/{id}', [SensorController::class, 'destroy'])->name('sensores.destroy'); 

// Rutas CRUD completas para Lectura
Route::get('lecturas', [LecturaController::class, 'index'])->name('lecturas.index');
Route::get('lecturas/create', [LecturaController::class, 'create'])->name('lecturas.create');
Route::post('lecturas', [LecturaController::class, 'store'])->name('lecturas.store');
Route::get('lecturas/{id}', [LecturaController::class, 'show'])->name('lecturas.show'); 
Route::get('lecturas/{id}/edit', [LecturaController::class, 'edit'])->name('lecturas.edit'); 
Route::put('lecturas/{id}', [LecturaController::class, 'update'])->name('lecturas.update'); 
Route::delete('lecturas/{id}', [LecturaController::class, 'destroy'])->name('lecturas.destroy'); 

// Rutas CRUD completas para Alerta
Route::get('alertas', [AlertaController::class, 'index'])->name('alertas.index');
Route::get('alertas/create', [AlertaController::class, 'create'])->name('alertas.create');
Route::post('alertas', [AlertaController::class, 'store'])->name('alertas.store');
Route::get('alertas/{id}', [AlertaController::class, 'show'])->name('alertas.show'); 
Route::get('alertas/{id}/edit', [AlertaController::class, 'edit'])->name('alertas.edit'); 
Route::put('alertas/{id}', [AlertaController::class, 'update'])->name('alertas.update'); 
Route::delete('alertas/{id}', [AlertaController::class, 'destroy'])->name('alertas.destroy'); 

// Rutas CRUD completas para Usuario
Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show'); 
Route::get('usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit'); 
Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update'); 
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy'); 

// Rutas CRUD completas para Configuración
Route::get('configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
Route::get('configuracion/create', [ConfiguracionController::class, 'create'])->name('configuracion.create');
Route::post('configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
Route::get('configuracion/{id}', [ConfiguracionController::class, 'show'])->name('configuracion.show');
Route::get('configuracion/{id}/edit', [ConfiguracionController::class, 'edit'])->name('configuracion.edit'); 
Route::put('configuracion/{id}', [ConfiguracionController::class, 'update'])->name('configuracion.update'); 
Route::delete('configuracion/{id}', [ConfiguracionController::class, 'destroy'])->name('configuracion.destroy');
Route::get('/configuracion/export', [ConfiguracionController::class, 'export'])->name('configuracion.export');
