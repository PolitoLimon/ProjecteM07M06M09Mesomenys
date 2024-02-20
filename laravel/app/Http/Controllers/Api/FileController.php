<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $files = File::all();

        if ($files) {
            return response()->json([
                'success' => true,
                'data' => $files
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error list files'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
       // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);
        // Desar fitxer al disc i inserir dades a BD
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',
            $uploadName,
            'public'
        );

        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Disk storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");

            // Creación de la entrada en la base de datos.
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);

            \Log::debug("DB storage OK");
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 201);
        } else {
            \Log::debug("Disk storage FAILS");
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
        //
        $file = File::find($id);
        if ($file) {
            return response()->json([
                'success' => true,
                'data' => $file
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error list file'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $file = File::find($id);
        if ($file) {
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
            ]);

            if ($request->hasFile('upload')) {
                \Storage::disk('public')->delete($file->filepath);
    
                $newFile = $request->file('upload');
                $newFileName = time() . '_' . $newFile->getClientOriginalName();
                $newFilePath = $newFile->storeAs('uploads', $newFileName, 'public');
    
                $file->update([
                    'original_name' => $newFile->getClientOriginalName(),
                    'filesize' => $newFile->getSize(),
                    'filepath' => $newFilePath,
                ]);
            }

            if ($file) {
                return response()->json([
                    'success' => true,
                    'data'    => $file
                ], 200);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error updating file'
                ], 500);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'File not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \Log::debug($id);
        $file = File::find($id);
        if ($file) {
            $file->delete();

            return response()->json([
                'success' => true,
                'data' => $file
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'File not found'
            ], 404);
        }
    }
    
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

}