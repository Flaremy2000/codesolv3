<?php

namespace App\Http\Controllers;

use App\Models\comision;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get All Comisiones
        $comisiones = comision::all();
        // Return json response with comisiones
        return response()->json($comisiones);
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
    public function show(comision $comision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comision $comision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comision $comision)
    {
        //
    }
}
