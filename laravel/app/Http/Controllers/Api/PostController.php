<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( $this->authorize('viewAny', Post::class)){
            
            $posts = Post::all();

            if ($posts) {
                return response()->json([
                    'success' => true,
                    'data' => $posts
                ], 200);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error list posts'
                ], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        if ( $this->authorize('create', Post::class)) {
            $validatedData = $request->validate([
                'title' => 'required|max:20',
                'description' => 'required|max:200',
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
                'visibility_id' => 'required|exists:visibilities,id', 
            ]);
            
            // Obtención de los datos del formulario.
            $upload = $request->file('upload');
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();

            // Almacenamiento del archivo en el sistema de archivos y la base de datos.
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',
                $uploadName,
                'public'
            );

            if (Storage::disk('public')->exists($filePath)) {

                $fullPath = Storage::disk('public')->path($filePath);

                // Creación de la entrada del archivo en la base de datos.
                $file = File::create([
                    'filepath' => $filePath,
                    'filesize' => $fileSize,
                ]);

                // Creación de la publicación en la base de datos.
                $post = Post::create([
                    'author_id' => auth()->user()->id,
                    'file_id' => $file->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'visibility_id' => $request->visibility_id
                ]);
                
                return response()->json([
                    'success' => true,
                    'data'    => $post
                ], 201);

            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading post'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        
        if ($post) {
            if ($this->authorize('view', $post)) {
                return response()->json([
                    'success' => true,
                    'data' => $post
                ], 200);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error show post'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if ($post) {
            if ( $this->authorize('update', $post)) {
                $validatedData = $request->validate([
                    'title' => 'required|max:20',
                    'description' => 'required|max:200',
                    'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
                    'visibility_id' => 'required|exists:visibilities,id', 
                ]);

                if ($request->hasFile('upload')) {
                    Storage::disk('public')->delete($post->file->filepath);
        
                    $newFile = $request->file('upload');
                    $newFileName = time() . '_' . $newFile->getClientOriginalName();
                    $newFilePath = $newFile->storeAs('uploads', $newFileName, 'public');
        
                    $post->file->update([
                        'original_name' => $newFile->getClientOriginalName(),
                        'filesize' => $newFile->getSize(),
                        'filepath' => $newFilePath,
                    ]);
                }

                $post->update([
                    'author_id' => auth()->user()->id,
                    'file_id' => $post->file->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'visibility_id' => $request->visibility_id,
                ]);

                if ($post) {
                    return response()->json([
                        'success' => true,
                        'data'    => $post
                    ], 200);
                } else {
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error updating post'
                    ], 500);
                }
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        $post = Post::find($id);
        if ($post) {
            if ( $this->authorize('delete', $post)) {
                if (Storage::disk('public')->exists($post->file->filepath)) {
                    Storage::disk('public')->delete($post->file->filepath);
                }
                $post->file->delete();
                $post->delete();

                return response()->json([
                    'success' => true,
                    'data' => $post
                ], 200);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function like(string $id)
    {
        $post = Post::find($id);
        $user = auth()->user();
        if ($post){
            if ( $this->authorize('like', $post)) {
                if (!$user->likes->contains($post->id)) {
                    $user->likes()->attach($post);
                    return response()->json([
                        'success' => true,
                        'data'    => ['Post liked successfully']
                    ], 200);
                }
            }
    
            return response()->json([
                'success'  => false,
                'message' => 'Post already liked'
            ], 404);
        }
        return response()->json([
            'success'  => false,
            'message' => 'Post not found'
        ], 404);
    }

    public function unlike(string $id)
    {
        $post = Post::find($id);
        $user = auth()->user();

        if ($post){
            if ($user->likes->contains($post->id)) {
                $user->likes()->detach($post);
                return response()->json([
                    'success' => true,
                    'data'    => ['Post unliked successfully']
                ], 200);        
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Post not liked'
                ], 404);
            }
                
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}