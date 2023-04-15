<?php

namespace App\Http\Controllers;

use App\Models\directorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class DirectorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create new directorio data in the DB and return a JSON response to the client side (VueJS) with the result of the operation (success or error) and the message to show to the user in the client side (VueJS)
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'directory_name' => 'required',
            'directory_lastname' => 'required',
            'Imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cargo' => 'required',
            'comisiones' => 'required',
            'periodo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Debe ingresar todos los datos', 'error' => $validator->errors()], 422);
        }

        try {
            // Create new directorio data
            $directorio = new directorio();
            $directorio->nombre_directorio = $request->directory_name;
            $directorio->apellido_directorio = $request->directory_lastname;
            $directorio->cargo_directorio = $request->cargo;
            $directorio->comision_directorio = $request->comisiones;
            $directorio->periodo_directorio = $request->periodo;
            $directorio->estado_directorio = 1;
            $image = $request->file('Imagen');
            $image = Image::make($image);
            $image->resize(210, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 75);
            $filename = time() . '.' . 'webp';
            $path = public_path('images/directorio/' . $request->periodo . '/' . $filename);
            $image->save($path);

            $directorio->imagen_directorio = $filename;

            $directorio->save();

            return response()->json(['message' => 'Directorio creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el directorio'], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id_periodo)
    {
        //get all directorio data, cargo data and comision where estado_directorio = 1 and periodo_directorio = $id_periodo and response it as json data
        $directorio = directorio::where("estado_directorio", 1)->where("periodo_directorio", $id_periodo)->with("cargo", "comision")->get();
        return response()->json($directorio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'directory_name' => 'required',
            'directory_lastname' => 'required',
            'cargo' => 'required',
            'comisiones' => 'required',
            'periodo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Debe ingresar todos los datos', 'error' => $validator->errors()], 422);
        }

        // Get the directorio data from the DB
        $directorio = directorio::find($id);
        if ($directorio) {
            try {
                // Update the directorio data
                $directorio->nombre_directorio = $request->directory_name;
                $directorio->apellido_directorio = $request->directory_lastname;
                $directorio->cargo_directorio = $request->cargo;
                $directorio->comision_directorio = $request->comisiones;
                $directorio->periodo_directorio = $request->periodo;

                if ($request->hasFile('Imagen')) {
                    $image = $request->file('Imagen');
                    $image = Image::make($image);
                    $image->resize(210, 250, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $image->encode('webp', 75);
                    $filename = time() . '.' . 'webp';
                    $path = public_path('images/directorio/' . $request->periodo . '/' . $filename);
                    $image->save($path);

                    $directorio->imagen_directorio = $filename;
                }

                $directorio->update();

                if ($request->hasFile('Imagen')) {
                    $oldImage = public_path('images/directorio/' . $request->periodo . '/' . $request->oldImage);
                    if (file_exists($oldImage)) {
                        @unlink($oldImage);
                    }
                }

                return response()->json(['message' => 'Directorio actualizado correctamente'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al actualizar el directorio'], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Inactivate the directorio data from the DB and return a JSON response to the client side (VueJS) with the result of the operation (success or error) and the message to show to the user in the client side (VueJS)
        $directorio = directorio::find($id);
        if ($directorio) {
            try {
                $directorio->estado_directorio = 0;
                $directorio->update();
                return response()->json(['message' => 'Directorio eliminado correctamente'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al eliminar el directorio'], 500);
            }
        }

    }
}