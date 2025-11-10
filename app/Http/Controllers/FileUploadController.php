<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar que la petición tenga un archivo llamado 'file'
        $request->validate([
            'file' => 'required|file|max:10240', // Ejemplo: obligatorio, tipo archivo, máx 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // 2. Generar nombre de archivo único
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 3. Mover el archivo a la carpeta 'public/uploads'
            // Esto creará la carpeta si no existe
            $file->move(public_path('uploads'), $filename); 

            // 4. Devolver una respuesta JSON para la petición AJAX
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente.',
                'filename' => $filename
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró el archivo.'
        ], 400);
    }
}