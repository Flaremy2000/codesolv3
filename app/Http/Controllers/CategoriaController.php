<?php

namespace App\Http\Controllers;

use App\Models\categoria;
use Illuminate\Http\Request;


class CategoriaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $page)
    {
        $userdata = json_decode($request->header('X-User-Data'));
        if (isset($userdata->role) && $userdata->role !== 2) {
            $categorias = categoria::pagina($page)
                ->estado(1)
                ->orderBy('nombre_categoria', 'ASC')->get();
            return response()->json($categorias, 200);
        } else {
            $categorias = categoria::pagina($page)
                ->estado(1)
                ->privacidad(1)
                ->orderBy('nombre_categoria', 'ASC')->get();
            return response()->json($categorias, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categoria $categoria)
    {
        //
    }
}
