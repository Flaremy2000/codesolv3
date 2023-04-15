<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $userdata = json_decode($request->header('X-User-Data'));
        if (isset($userdata->role) && $userdata->role !== 2) {
            $documents = Document::join('categorias', 'categorias.id_categoria', '=', 'document.id_categoria')->get();
            return response()->json($documents, 200);
        } else {
            $documents = Document::join('categorias', 'categorias.id_categoria', '=', 'document.id_categoria')
                ->where('categorias.privacidad_categoria', '!=', 0)
                ->get();
            return response()->json($documents, 200);
        }
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
        //Get all documents by category id and return them as json response with status code 200 (OK)
        $documents = Document::where('id_categoria', $id_cat)->get();
        return response()->json($documents, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentController $documentController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentController $documentController)
    {
        //
    }
}