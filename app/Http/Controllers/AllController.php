<?php

namespace App\Http\Controllers;

use App\Models\noticia;
use App\Models\categoria;
use Illuminate\Http\Request;

class AllController extends Controller
{

    public function getNoticias()
    {
        $noticias = noticia::all();
        return response()->json($noticias);
    }

}