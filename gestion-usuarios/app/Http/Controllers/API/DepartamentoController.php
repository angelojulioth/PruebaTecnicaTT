<?php
// app/Http/Controllers/API/DepartamentoController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentDepartamento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartamentoController extends Controller
{
  public function index(): JsonResponse
  {
    $departamentos = EloquentDepartamento::all();
    return response()->json($departamentos);
  }

  public function store(Request $request): JsonResponse
  {
    try {
      $this->validate($request, [
        'nombre' => 'required|string|max:100|unique:departamentos,nombre',
      ], [
        'nombre.required' => 'El nombre del departamento es obligatorio',
        'nombre.unique' => 'Este nombre de departamento ya existe',
      ]);

      $departamento = EloquentDepartamento::create([
        'nombre' => $request->nombre,
      ]);

      return response()->json([
        'mensaje' => 'Departamento creado exitosamente',
        'departamento' => $departamento
      ], 201);
    } catch (ValidationException $e) {
      return response()->json(['errores' => $e->errors()], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al crear el departamento: ' . $e->getMessage()], 500);
    }
  }

  public function show(int $id): JsonResponse
  {
    $departamento = EloquentDepartamento::find($id);

    if (!$departamento) {
      return response()->json(['error' => 'Departamento no encontrado'], 404);
    }

    return response()->json($departamento);
  }

  public function update(Request $request, int $id): JsonResponse
  {
    $departamento = EloquentDepartamento::find($id);

    if (!$departamento) {
      return response()->json(['error' => 'Departamento no encontrado'], 404);
    }

    try {
      $this->validate($request, [
        'nombre' => 'required|string|max:100|unique:departamentos,nombre,' . $id,
      ], [
        'nombre.required' => 'El nombre del departamento es obligatorio',
        'nombre.unique' => 'Este nombre de departamento ya existe',
      ]);

      $departamento->update([
        'nombre' => $request->nombre,
      ]);

      return response()->json([
        'mensaje' => 'Departamento actualizado exitosamente',
        'departamento' => $departamento
      ]);
    } catch (ValidationException $e) {
      return response()->json(['errores' => $e->errors()], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar el departamento: ' . $e->getMessage()], 500);
    }
  }

  public function destroy(int $id): JsonResponse
  {
    $departamento = EloquentDepartamento::find($id);

    if (!$departamento) {
      return response()->json(['error' => 'Departamento no encontrado'], 404);
    }

    try {
      // Verificar si hay usuarios asociados a este departamento
      if ($departamento->usuarios()->count() > 0) {
        return response()->json(['error' => 'No se puede eliminar este departamento porque tiene usuarios asociados'], 400);
      }

      $departamento->delete();

      return response()->json([
        'mensaje' => 'Departamento eliminado exitosamente'
      ]);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar el departamento: ' . $e->getMessage()], 500);
    }
  }
}