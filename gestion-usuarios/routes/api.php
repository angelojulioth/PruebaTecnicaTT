<?php

use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\DepartamentoController;
use App\Http\Controllers\API\CargoController;
use Illuminate\Support\Facades\Route;


// Usuario routes
Route::controller(UsuarioController::class)->group(function () {
  Route::get('/usuarios', 'index');
  Route::post('/usuarios', 'store');
  Route::get('/usuarios/{id}', 'show');
  Route::put('/usuarios/{id}', 'update');
  Route::delete('/usuarios/{id}', 'destroy');
});

// Departamento routes
Route::controller(DepartamentoController::class)->group(function () {
  Route::get('/departamentos', 'index');
  Route::post('/departamentos', 'store');
  Route::get('/departamentos/{id}', 'show');
  Route::put('/departamentos/{id}', 'update');
  Route::delete('/departamentos/{id}', 'destroy');
});

// Cargo routes
Route::controller(CargoController::class)->group(function () {
  Route::get('/cargos', 'index');
  Route::post('/cargos', 'store');
  Route::get('/cargos/{id}', 'show');
  Route::put('/cargos/{id}', 'update');
  Route::delete('/cargos/{id}', 'destroy');
});

// Test route para API
Route::get('/test', function () {
  return response()->json(['message' => 'Api funciona']);
});