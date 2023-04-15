<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DocumentController extends Controller
{
    protected $datenow;

    public function __construct()
    {
        $this->datenow = Carbon::now('America/Guayaquil')->format('Y-m-d');
    }

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
        $userdata = json_decode($request->header('X-User-Data'));
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'id_categoria' => 'required',
            'archivo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $document = new Document();
            $document->title = $request->title;
            $document->id_categoria = $request->id_categoria;
            $document->created_by = $userdata->id_user;
            $document->updated_by = $userdata->id_user;
            $document->date = $this->datenow;
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('documents/transparent/', $filename);
                $document->file = $filename;
            }
            $document->save();
            return response()->json(['message' => 'Documento creado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}