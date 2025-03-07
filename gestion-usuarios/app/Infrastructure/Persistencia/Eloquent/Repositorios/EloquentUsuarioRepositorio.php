<?php
// app/Infrastructure/Persistencia/Eloquent/Repositorios/EloquentUsuarioRepositorio.php

namespace App\Infrastructure\Persistencia\Eloquent\Repositorios;

use App\Core\Application\Interfaces\RepositorioUsuarioInterface;
use App\Core\Domain\Entidades\Usuario;
use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentUsuario;

class EloquentUsuarioRepositorio implements RepositorioUsuarioInterface
{
  public function obtenerTodos(): array
  {
    $usuariosEloquent = EloquentUsuario::all();

    $usuarios = [];
    foreach ($usuariosEloquent as $usuarioEloquent) {
      $usuarios[] = $this->mapearADominio($usuarioEloquent);
    }

    return $usuarios;
  }

  public function obtenerPorId(int $id): ?Usuario
  {
    $usuarioEloquent = EloquentUsuario::find($id);

    if (!$usuarioEloquent) {
      return null;
    }

    return $this->mapearADominio($usuarioEloquent);
  }

  public function obtenerPorUsuario(string $usuario): ?Usuario
  {
    $usuarioEloquent = EloquentUsuario::where('usuario', $usuario)->first();

    if (!$usuarioEloquent) {
      return null;
    }

    return $this->mapearADominio($usuarioEloquent);
  }

  public function guardar(Usuario $usuario): Usuario
  {
    $usuarioEloquent = new EloquentUsuario([
      'usuario' => $usuario->getUsuario(),
      'primer_nombre' => $usuario->getPrimerNombre(),
      'segundo_nombre' => $usuario->getSegundoNombre(),
      'primer_apellido' => $usuario->getPrimerApellido(),
      'segundo_apellido' => $usuario->getSegundoApellido(),
      'email' => $usuario->getEmail(),
      'departamento_id' => $usuario->getDepartamentoId(),
      'cargo_id' => $usuario->getCargoId(),
    ]);

    $usuarioEloquent->save();

    return $this->mapearADominio($usuarioEloquent);
  }

  public function actualizar(Usuario $usuario): Usuario
  {
    $usuarioEloquent = EloquentUsuario::find($usuario->getId());

    if (!$usuarioEloquent) {
      throw new \Exception("Usuario no encontrado con ID: {$usuario->getId()}");
    }

    $usuarioEloquent->update([
      'usuario' => $usuario->getUsuario(),
      'primer_nombre' => $usuario->getPrimerNombre(),
      'segundo_nombre' => $usuario->getSegundoNombre(),
      'primer_apellido' => $usuario->getPrimerApellido(),
      'segundo_apellido' => $usuario->getSegundoApellido(),
      'email' => $usuario->getEmail(),
      'departamento_id' => $usuario->getDepartamentoId(),
      'cargo_id' => $usuario->getCargoId(),
    ]);

    return $this->mapearADominio($usuarioEloquent->fresh());
  }

  public function eliminar(int $id): bool
  {
    $usuarioEloquent = EloquentUsuario::find($id);

    if (!$usuarioEloquent) {
      return false;
    }

    return $usuarioEloquent->delete();
  }

  private function mapearADominio(EloquentUsuario $usuarioEloquent): Usuario
  {
    return new Usuario(
      $usuarioEloquent->usuario,
      $usuarioEloquent->primer_nombre,
      $usuarioEloquent->segundo_nombre,
      $usuarioEloquent->primer_apellido,
      $usuarioEloquent->segundo_apellido,
      $usuarioEloquent->email,
      $usuarioEloquent->departamento_id,
      $usuarioEloquent->cargo_id,
      $usuarioEloquent->id
    );
  }
}