<?php

use App\Http\Controllers\AllController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/transparent', function () {
    return view('transparent');
});

Route::get('/news', function () {
    return view('news');
});

Route::get('/atention', function () {
    return view('atention');
});

Route::get('/solicitud', function () {
    return view('solicitudes');
});

Route::get('/members', function () {
    return view('members');
})->middleware('auth');

Route::get('/facturas', function () {
    return view('facturas');
})->middleware('auth');

Route::get('/reporte', function () {
    return view('reporte');
})->middleware('auth');

Route::get('/myreport', function () {
    return view('myreport');
})->middleware('auth');

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/contenido_noticia/{id}', function ($id) {
    return view('contenido_noticia', ['id' => $id]);
});

Route::get('/cambiar_contraseña/{id}', function ($id) {
    return view('changepss', ['id' => $id]);
});

Route::post('/login', LoginController::class . '@login');
Route::post('/logout', LoginController::class . '@logout');
Route::post('/newpass', LoginController::class . '@changePassword');

Route::get('/detallnoticia/{id}', NoticiaController::class . '@getNoticia');

Route::get('/allnews', AllController::class . '@getNoticias');