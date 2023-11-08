<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

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
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
       
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        \Log::debug("Storing file '{$fileName}' ($fileSize)...");
 
 
        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
       
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Disk storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('files.show', $file)
                ->with('success', 'File successfully saved');
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("files.create")
                ->with('error', 'ERROR uploading file');
        }
 
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        $files = File::find($file);

        if (!$file) {
            return redirect()->route('files.index')->with('error', 'File not found');
        }

        // Verificar si el archivo existe en el disco
        $fileExists = Storage::exists($files->filepath);

        if (!$fileExists) {
            return redirect()->route('files.index')->with('error', 'File not found on disk');
        }

        return view('files.show', compact('file'));

    /**
     * Show the form for editing the specified resource.
     */
    }
    public function edit(File $file)
    {

            $file = File::find($file);
        
            if (!$file) {
                return redirect()->route('files.index')->with('error', 'File not found');
            }
        
            return view('files.edit', compact('file'));
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        $files = File::find($file);

        if (!$files) {
            return redirect()->route('files.index')->with('error', 'File not found');
        }
    
        $request->validate([
            'upload' => 'image|mimes:jpeg,png,gif|max:2048', // Validación del archivo (opcional)
        ]);
    
        if ($request->hasFile('upload')) {
            // Actualizar archivo en el disco
            $path = $request->file('upload')->store('public/uploads');
            $files->filepath = $path;
        }
    
        // Actualizar otros campos del archivo
        $file->name = $request->input('name');
        $file->description = $request->input('description');
    
        $file->save();
    
        return redirect()->route('files.show', $file->id)->with('success', 'File updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $files = File::find($file);

        if (!$files) {
            return redirect()->route('files.index')->with('error', 'File not found');
        }
    
        // Eliminar archivo del disco
        Storage::delete($file->filepath);
    
        // Eliminar registro de la base de datos
        $files->delete();
    
        return redirect()->route('files.index')->with('success', 'File deleted successfully');
    }
}
