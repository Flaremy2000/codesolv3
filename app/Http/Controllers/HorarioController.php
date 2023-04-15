<?php

namespace App\Http\Controllers;

use App\Models\horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
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
    public function show($id_cat)
    {
        // Get all horarios from a category by id and return it as json data to Vue component
        $horarios = horario::where('id_categoria', $id_cat)->get();
        return response()->json($horarios);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, horario $horario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(horario $horario)
    {
        //
    }
}