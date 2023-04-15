<?php

namespace App\Http\Controllers;

use App\Models\noticia;
use App\Models\categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get All Noticias from DB and paginate them to 6 per page (default) and total page and estado equals 1 and return response in JSON format
        $noticias = noticia::where('estado', 1)->paginate(6);
        return response()->json($noticias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'fecha' => 'required',
            'notcategory' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $noticia = new noticia();
            $noticia->titulo = $request->title;
            if ($request->texto_largo != null) {
                $noticia->texto_largo = $request->texto_largo;
            }
            $noticia->fecha = $request->fecha;
            $noticia->categoria_id = $request->notcategory;
            if ($request->hasFile('imagen')) {
                $images = $request->file('imagen');

                $images = Image::make($images);

                $images->resize(340, 310, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $images->encode('webp', 75);

                $filename = time() . '.' . 'webp';
                $path = public_path('images/noticias/' . $filename);
                $images->save($path);

                $noticia->imagen = $filename;
            }

            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('documents/news/', $filename);
                $noticia->archivo = $filename;
            }

            $noticia->save();

            return response()->json(['succeso' => 'Noticia creada correctamente'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($cat)
    {
        //Get All Noticias from DB and paginate them to 10 per page (default) and estado equals 1 and return response in JSON format
        $noticias = noticia::where('estado', 1)->where('categoria_id', $cat)->paginate(6);
        return response()->json($noticias);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'fecha' => 'required',
            'notcategory' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $noticia = noticia::find($id);
            if ($noticia) {
                $noticia->titulo = $request->title;
                $noticia->fecha = $request->fecha;
                $noticia->categoria_id = $request->notcategory;
                if ($request->texto_largo != null) {
                    $noticia->texto_largo = $request->texto_largo;
                }
                if ($request->hasFile('imagen')) {
                    $images = $request->file('imagen');

                    $images = Image::make($images);

                    $images->resize(340, 310, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $images->encode('webp', 95);

                    $filename = time() . '.' . 'webp';
                    $path = public_path('images/noticias/' . $filename);
                    $images->save($path);

                    // Delete old image
                    $oldImage = public_path('images/noticias/' . $noticia->imagen);
                    if (file_exists($oldImage)) {
                        @unlink($oldImage);
                    }

                    $noticia->imagen = $filename;
                }

                if ($request->hasFile('archivo')) {
                    $file = $request->file('archivo');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move('documents/news/', $filename);

                    // Delete old file
                    $oldFile = public_path('documents/news/' . $noticia->archivo);
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }

                    $noticia->archivo = $filename;
                }

                $noticia->updateOrFail();

                return response()->json(['succeso' => 'Noticia actualizada correctamente'], 200);
            } else {
                return response()->json(['error' => 'Noticia no encontrada'], 401);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $noticia = noticia::find($id);
            if ($noticia) {
                //  Delete old image
                $oldImage = public_path('images/noticias/' . $noticia->imagen);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                // Delete old file
                $oldFile = public_path('documents/news/' . $noticia->archivo);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }

                $noticia->delete();
                return response()->json(['succeso' => 'Noticia eliminada correctamente'], 200);
            } else {
                return response()->json(['error' => 'Noticia no encontrada'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function getNoticia(noticia $id)
    {
        $categoria = categoria::where('id_categoria', $id->categoria_id)->first();
        $id->categoria = $categoria->nombre_categoria;
        return response()->json($id);
    }

}