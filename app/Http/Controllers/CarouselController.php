<?php

namespace App\Http\Controllers;

use App\Models\carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;


class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get All Carousels Where scopePage = home and scopeActive = 1 from DB and return them as JSON to the client side (VueJS)
        return carousel::active()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Save the carousel in the DB and return a JSON response to the client side (VueJS) with the result of the operation (success or error) and the message to show to the user in the client side (VueJS)
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Debe ingresar un título'], 422);
        }

        try {
            $carousel = new carousel();
            $carousel->carousel_title = $request->title;
            $carousel->carousel_page = $request->page;
            $image = $request->file('Image');

            $image = Image::make($image);
            $image->resize(1920, 680, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->encode('webp', 75);

            $filename = time() . '.' . 'webp';
            $path = public_path('images/' . $filename);
            $image->save($path);

            $carousel->carousel_image = $filename;

            $carousel->save();

            return response()->json(array('message' => '¡ Carrusel Creado Correctamente !', ), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor intente mas tarde'
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($pages)
    {
        //Get the carousel with carrousel_page is equal a $page from DB and return it as JSON to the client side (VueJS)
        return carousel::page($pages)->active()->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Log::info($request->all()); // Imprimir el contenido de la solicitud en el registro

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'page' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        try {

            $carousel = carousel::find($id);
            if ($carousel) {
                $carousel->carousel_title = $request->title;
                $carousel->carousel_page = $request->page;
                if ($request->hasFile('Image')) {
                    $image = $request->file('Image');

                    $image = Image::make($image);
                    $image->resize(1920, 680, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $image->encode('webp', 75);

                    $filename = time() . '.' . 'webp';
                    $path = public_path('images/' . $filename);
                    $image->save($path);

                    $carousel->carousel_image = $filename;
                }
                $carousel->update();

                // Delete the old image from the server
                if ($request->hasFile('Image')) {
                    $oldImage = public_path('images/' . $request->image_carousel_old);
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }

                return response()->json(
                    array(
                        'message' => '¡ Carrusel Actualizado Correctamente !',
                    ),
                    200
                );
            } else {
                return response()->json(
                    array(
                        'message' => 'Error en el servidor intente mas tarde, si el error persiste contacte al administrador del sistema',
                    ),
                    404
                );
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Inactive the carousel in the DB and return a JSON response to the client side (VueJS) with the result of the operation (success or error) and the message to show to the user in the client side (VueJS)
        $carousel = carousel::find($id);
        if ($carousel) {
            try {
                $carousel->estado = 0;
                $carousel->update();
                return response()->json(array('message' => '¡ Carrusel Eliminado Correctamente !'), 200);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'No elimino, Error en el servidor intente mas tarde, si el error persiste contacte al administrador del sistema'
                ], 500);
            }
        }
    }
}