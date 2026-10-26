<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('productos', ProductoController::class);
Route::apiResource('almacenes', AlmacenController::class)
    ->parameters(['almacenes' => 'almacen']);
Route::apiResource('movimientos', MovimientoController::class);
Route::apiResource('categorias', CategoriaController::class)
    ->only(['destroy']);
