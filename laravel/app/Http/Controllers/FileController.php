<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("files.index", [
            "files" => File::all()
        ]);
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("files.create");
    }
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
       
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        \Log::debug("Storing file '{$fileName}' ($fileSize)...");
 
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      
            $uploadName , 
            'public'
        );
       
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Disk storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            \Log::debug("DB storage OK");
            return redirect()->route('files.show', $file)
                ->with('success', 'File successfully saved');
        } else {
            \Log::debug("Disk storage FAILS");
            return redirect()->route("files.create")
                ->with('error', 'ERROR uploading file');
        }
    }
 

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        $fileExists = Storage::disk('public')->exists($file->filepath);
        if (!$fileExists) {
            return redirect()->route('files.index')->with('error', 'Fitxer no trobat');
        }
        return view('files.show', compact('file')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        return view('files.edit', compact('file'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        // Validar los datos del formulario
        $request->validate([
            'upload' => 'mimes:gif,jpeg,jpg,png|max:1024', // Ajusta las reglas según tus necesidades
        ]);
    
        // Comprueba si se ha enviado un nuevo archivo
        if ($request->hasFile('upload')) {
            // Elimina el archivo anterior del disco
            Storage::disk('public')->delete($file->filepath);
    
            // Sube el nuevo archivo al disco
            $newFile = $request->file('upload');
            $newFileName = time() . '_' . $newFile->getClientOriginalName();
            $newFilePath = $newFile->storeAs('uploads', $newFileName, 'public');
    
            // Actualiza la información del archivo en la base de datos
            $file->update([
                'original_name' => $newFile->getClientOriginalName(),
                'filesize' => $newFile->getSize(),
                'filepath' => $newFilePath,
            ]);
        }
        return redirect()->route('files.show', $file)->with('success', 'Archivo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        // Eliminar el archivo del disco
        Storage::disk('public')->delete($file->filepath);
    
        // Eliminar el registro de la base de datos
        $file->delete();
    
        return redirect()->route('files.index')->with('success', 'Archivo eliminado con éxito');
    }
}