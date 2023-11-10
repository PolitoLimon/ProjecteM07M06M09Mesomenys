<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("posts.index", [
            "posts" => Post::paginate(5),
            // "files" => File::all(),
            // "users" => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
            'title' => 'required|max:20',
            'description' => 'required|max:200'
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
            $post = Post::create([
                'author_id' => $user = auth()->user()->id,
                'file_id' => $file->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return redirect()->route('posts.show', $post)
                ->with('success', 'File successfully saved');
        } else {
            \Log::debug("Disk storage FAILS");
            return redirect()->route("posts.create")
                ->with('error', 'ERROR uploading file');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        $fileExists = Storage::disk('public')->exists($post->file->filepath);
        if (!$fileExists) {
            return redirect()->route('posts.index')->with('error', 'Fitxer no trobat');
        }
        if (!$post->id){
            return redirect()->route('posts.index')->with('error', 'Post no trobat');
        }
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
        // Validar los datos del formulario
        $request->validate([
            'upload' => 'mimes:gif,jpeg,jpg,png|max:1024',
            'title' => 'required|max:20',
            'description' => 'required|max:200'
        ]);

        if ($request->hasFile('upload')) {
            // Elimina el archivo anterior del disco
            Storage::disk('public')->delete($post->file->filepath);
    
            // Sube el nuevo archivo al disco
            $newFile = $request->file('upload');
            $newFileName = time() . '_' . $newFile->getClientOriginalName();
            $newFilePath = $newFile->storeAs('uploads', $newFileName, 'public');
            // Actualiza la información del archivo en la base de datos
            // dd($post->file);
            $post->file->update([
                'original_name' => $newFile->getClientOriginalName(),
                'filesize' => $newFile->getSize(),
                'filepath' => $newFilePath,
            ]);
        }
        $post->update([
            'author_id' => $user = auth()->user()->id,
            'file_id' => $post->file->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return redirect()->route('posts.show', $post)->with('success', 'Archivo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->file->filepath);
        $post->delete();
        $post->file->delete();
        return redirect()->route('posts.index')->with('success', 'Archivo eliminado con éxito');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $posts = Post::where('title', 'like', '%' . $searchTerm . '%')->paginate(5);
        return view('posts.index', ['posts' => $posts]);
    }
}