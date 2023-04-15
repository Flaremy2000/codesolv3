<?php

namespace App\Http\Controllers;

use App\Models\sugerencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SugerenciasController extends Controller
{

    protected $datenow;

    public function __construct()
    {
        $this->datenow = Carbon::now('America/Guayaquil')->format('Y-m-d');
    }

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
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required',
            'sugerencia' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al crear la sugerencia',
                'errors' => $validator->errors()
            ], 422);
        }
        //Get new Sugestion and Save it in DB
        $sugerencia = new sugerencias();
        $sugerencia->id_usuario = $request->id_usuario;
        $sugerencia->sugerencia = $request->sugerencia;
        $sugerencia->fecha = $this->datenow;
        $sugerencia->save();
        // Return message to user
        return response()->json([
            'message' => 'Sugerencia creada correctamente'
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(sugerencias $sugerencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sugerencias $sugerencias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sugerencias $sugerencias)
    {
        //
    }
}