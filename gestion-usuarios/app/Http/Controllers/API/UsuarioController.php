<?php
// app/Http/Controllers/API/UsuarioController.php

namespace App\Http\Controllers\API;

use App\Core\Application\DTOs\UsuarioDTO;
use App\Core\Application\Interfaces\ServicioUsuarioInterface;
use App\Core\Domain\Excepciones\UsuarioExcepcion;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarUsuarioRequest;
use App\Http\Requests\CrearUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsuarioController extends Controller
{
  private ServicioUsuarioInterface $servicioUsuario;

  public function __construct(ServicioUsuarioInterface $servicioUsuario)
  {
    $this->servicioUsuario = $servicioUsuario;
  }

  public function index(): AnonymousResourceCollection
  {
    $usuarios = $this->servicioUsuario->obtenerTodos();
    return UsuarioResource::collection($usuarios);
  }

  public function store(CrearUsuarioRequest $request): JsonResponse
  {
    try {
      $usuarioDTO = UsuarioDTO::fromArray($request->validated());
      $usuario = $this->servicioUsuario->crearUsuario($usuarioDTO);

      return response()->json([
        'mensaje' => 'Usuario creado exitosamente',
        'usuario' => new UsuarioResource($usuario)
      ], 201);
    } catch (UsuarioExcepcion $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al crear el usuario: ' . $e->getMessage()], 500);
    }
  }

  public function show(int $id): JsonResponse
  {
    try {
      $usuario = $this->servicioUsuario->obtenerPorId($id);
      return response()->json(new UsuarioResource($usuario));
    } catch (UsuarioExcepcion $e) {
      return response()->json(['error' => $e->getMessage()], 404);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al obtener el usuario: ' . $e->getMessage()], 500);
    }
  }

  public function update(ActualizarUsuarioRequest $request, int $id): JsonResponse
  {
    try {
      $usuarioDTO = UsuarioDTO::fromArray($request->validated());
      $usuario = $this->servicioUsuario->actualizarUsuario($id, $usuarioDTO);

      return response()->json([
        'mensaje' => 'Usuario actualizado exitosamente',
        'usuario' => new UsuarioResource($usuario)
      ]);
    } catch (UsuarioExcepcion $e) {
      return response()->json(['error' => $e->getMessage()], 404);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()], 500);
    }
  }

  public function destroy(int $id): JsonResponse
  {
    try {
      $this->servicioUsuario->eliminarUsuario($id);

      return response()->json([
        'mensaje' => 'Usuario eliminado exitosamente'
      ]);
    } catch (UsuarioExcepcion $e) {
      return response()->json(['error' => $e->getMessage()], 404);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()], 500);
    }
  }
}