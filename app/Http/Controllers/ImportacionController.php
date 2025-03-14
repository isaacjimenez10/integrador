<?php

namespace App\Http\Controllers;

use App\Imports\ClientesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportacionController extends Controller
{
    public function import(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Cambiar 'file' por 'archivo'
        ]);

        try {
            Excel::import(new ClientesImport, $request->file('file')); // Cambiar 'file' por 'archivo'
            return redirect()->back()->with('success', 'Clientes importados exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage());
        }

    }
}