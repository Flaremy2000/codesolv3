<?php

namespace App\Http\Controllers;

use App\Models\reporte;
use App\Models\imagereport;
use Illuminate\Http\Request;

class ReporteController extends Controller
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
    public function show($id_user)
    {
        //Get all reports from a user with status 1 (active)
        $reportes = reporte::where('id_user', $id_user)->get();

        //Get all images from a report
        foreach ($reportes as $reporte) {
            // Get all images from table imagereports where id_report is equal to $reporte->id
            $reporte->images = imagereport::where('id_reporte', $reporte->id_reporte)->get();
        }

        return response()->json($reportes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reporte $reporte)
    {
        //
    }
}