<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File; // Asegúrate de importar el modelo File

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::all();
        return response()->json([
            'success' => true,
            'data'    => $files
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);

        $upload = $request->file('upload');
        $file = new File();
        $ok = $file->diskSave($upload); // Método de almacenamiento en disco

        if ($ok) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $file = File::find($id);
        if ($file) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $file = File::find($id);
        if ($file) {
            // Lógica de actualización del archivo
            return response()->json([
                'success' => true,
                'data'    => $file
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);
        if ($file) {
            // Lógica de eliminación del archivo
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
    }
}
