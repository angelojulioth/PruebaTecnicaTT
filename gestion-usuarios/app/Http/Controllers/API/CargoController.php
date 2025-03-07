<?php
// app/Http/Controllers/API/CargoController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentCargo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CargoController extends Controller
{
  public function index(): JsonResponse
  {
    $cargos = EloquentCargo::all();
    return response()->json($cargos);
  }

  public function store(Request $request): JsonResponse
  {
    try {
      $this->validate($request, [
        'nombre' => 'required|string|max:100|unique:cargos,nombre',
      ], [
        'nombre.required' => 'El nombre del cargo es obligatorio',
        'nombre.unique' => 'Este nombre de cargo ya existe',
      ]);

      $cargo = EloquentCargo::create([
        'nombre' => $request->nombre,
      ]);

      return response()->json([
        'mensaje' => 'Cargo creado exitosamente',
        'cargo' => $cargo
      ], 201);
    } catch (ValidationException $e) {
      return response()->json(['errores' => $e->errors()], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al crear el cargo: ' . $e->getMessage()], 500);
    }
  }

  public function show(int $id): JsonResponse
  {
    $cargo = EloquentCargo::find($id);

    if (!$cargo) {
      return response()->json(['error' => 'Cargo no encontrado'], 404);
    }

    return response()->json($cargo);
  }

  public function update(Request $request, int $id): JsonResponse
  {
    $cargo = EloquentCargo::find($id);

    if (!$cargo) {
      return response()->json(['error' => 'Cargo no encontrado'], 404);
    }

    try {
      $this->validate($request, [
        'nombre' => 'required|string|max:100|unique:cargos,nombre,' . $id,
      ], [
        'nombre.required' => 'El nombre del cargo es obligatorio',
        'nombre.unique' => 'Este nombre de cargo ya existe',
      ]);

      $cargo->update([
        'nombre' => $request->nombre,
      ]);

      return response()->json([
        'mensaje' => 'Cargo actualizado exitosamente',
        'cargo' => $cargo
      ]);
    } catch (ValidationException $e) {
      return response()->json(['errores' => $e->errors()], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar el cargo: ' . $e->getMessage()], 500);
    }
  }

  public function destroy(int $id): JsonResponse
  {
    $cargo = EloquentCargo::find($id);

    if (!$cargo) {
      return response()->json(['error' => 'Cargo no encontrado'], 404);
    }

    try {
      // Verificar si hay usuarios asociados a este cargo
      if ($cargo->usuarios()->count() > 0) {
        return response()->json(['error' => 'No se puede eliminar este cargo porque tiene usuarios asociados'], 400);
      }

      $cargo->delete();

      return response()->json([
        'mensaje' => 'Cargo eliminado exitosamente'
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar el cargo: ' . $e->getMessage()], 500);
    }
  }
}