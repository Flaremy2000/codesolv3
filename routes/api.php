<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SugerenciasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('carousel', CarouselController::class);
Route::apiResource('periodos', PeriodoController::class);
Route::apiResource('directorio', DirectorioController::class);
Route::apiResource('comision', ComisionController::class);
Route::apiResource('cargo', CargoController::class);
Route::apiResource('categoria', CategoriaController::class);
Route::apiResource('noticia', NoticiaController::class);
Route::apiResource('user', UserController::class);
Route::apiResource('documento', DocumentController::class);
Route::apiResource('sugestion', SugerenciasController::class);
Route::apiResource('horario', HorarioController::class);
Route::apiResource('reporte', ReporteController::class);