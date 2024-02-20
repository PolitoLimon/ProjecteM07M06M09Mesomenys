<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\File;
use App\Models\User;

use Illuminate\Support\Facades\Auth;


class PlaceController extends Controller
{  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( $this->authorize('viewAny', App\Models\Place::class)) {
            $places = Place::all();

            if ($places) {
                return response()->json([
                    'success' => true,
                    'data' => $places
                ], 200);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error list files'
                ], 500);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ( $this->authorize('create', App\Models\Place::class)) {
            $validatedData = $request->validate([
                'title'         => 'required|max:30',
                'latitude'      => 'required|max:9',
                'longitude'     => 'required|max:9',
                'descripcion'   => 'required|max:200',
                'visibility_id' => 'required|exists:visibilities,id', 
                'upload'        => 'required|mimes:gif,jpeg,jpg,png|max:1024',
            ]);
            
            $upload    = $request->file('upload');
            $fileName  = $upload->getClientOriginalName();
            $fileSize  = $upload->getSize();
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',
                $uploadName,
                'public'
            );

            if (\Storage::disk('public')->exists($filePath)) {
                $fullPath = \Storage::disk('public')->path($filePath);  
                \Log::debug("File saved at {$fullPath}");
                
                $file = File::create([
                    'filepath' => $filePath,
                    'filesize' => $fileSize,
                ]);

                $place = Place::create([
                    'title'       => $request->title,
                    'latitude'    => $request->latitude,
                    'longitude'   => $request->longitude,
                    'descripcion' => $request->descripcion,
                    'file_id'     => $file->id,
                    'author_id' => auth()->user()->id,
                    'visibility_id' => $request->visibility_id,
                ]);

                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201);

            } else {
                \Log::debug("Disk storage FAILS");
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading file'
                ], 500);
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'success'  => false,
                'message' => 'Error show place'
            ], 404);
        } 

        if ( $this->authorize('view', $place)) {
            return response()->json([
                'success' => true,
                'data' => $place
            ], 200);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $place = Place::find($id);
        if ($place) {
            if ( $this->authorize('update', $place)) {
                $validatedData = $request->validate([
                    'title'         => 'required|max:30',
                    'latitude'      => 'required|max:9',
                    'longitude'     => 'required|max:9',
                    'descripcion'   => 'required|max:200',
                    'visibility_id' => 'required|exists:visibilities,id',
                ]);

                if ($request->hasFile('upload')) {
                    \Storage::disk('public')->delete($place->file->filepath);
                    $newFile = $request->file('upload');
                    $newFileName = time() . '_' . $newFile->getClientOriginalName();
                    $newFilePath = $newFile->storeAs('uploads', $newFileName, 'public');
                    $place->file->update([
                        'original_name' => $newFile->getClientOriginalName(),
                        'filesize'      => $newFile->getSize(),
                        'filepath'      => $newFilePath,
                    ]);
                }

                $place->update([
                    'title'       => $request->title,
                    'latitude'    => $request->latitude,
                    'longitude'   => $request->longitude,
                    'descripcion' => $request->descripcion,
                    'file_id'     => $place->file->id,
                    'visibility_id' => $request->visibility_id, 
                ]);
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 200);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Place not found'
            ], 404);
        }
    }

    /**
     * Marca un lugar como favorito para el usuario autenticado.
     */
    public function favorite(string $id)
    {
        $place = Place::find($id);
        if ($place){
            $user = auth()->user();
            if (!$user->favorites->contains($place->id)) {
                $user->favorites()->attach($place);
                return response()->json([
                    'success' => true,
                    'data' => [ 'Lugar marcado como favorito.'
                    ]
                ], 200);
            } else {
                if ( $this->authorize('favorite', $place)) {
                    return response()->json([
                        'success' => false,
                        'error' => 'El lugar ya está marcado como favorito.'
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'error' => 'Lugar no encontrado.'
            ], 404);
        }
    }

    /**
     * Desmarca un lugar como favorito para el usuario autenticado.
     */
    public function unfavorite(string $id)
    {
        $place = Place::find($id);
        if ($place) {
            $user = auth()->user();
            if ($user->favorites->contains($place->id)) {
                $user->favorites()->detach($place);
                return response()->json([
                    'success' => true,
                    'data' => ['Lugar eliminado de favoritos.']
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'El lugar no está marcado como favorito.'
                ], 400);
            }
        } else {
            return response()->json([
                'error' => 'Lugar no encontrado.',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \Log::debug($id);
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'success'  => false,
                'message' => 'Place not found'
            ], 404);
        }

        if ( $this->authorize('delete', $place)) {
            $place->delete();
            $place->file->delete();

            return response()->json([
                'success' => true,
                'data' => $place
            ], 200);
        } 
    }
}