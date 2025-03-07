<?php
// app/Core/Application/Servicios/UsuarioServicio.php

namespace App\Core\Application\Servicios;

use App\Core\Application\DTOs\UsuarioDTO;
use App\Core\Application\Interfaces\RepositorioUsuarioInterface;
use App\Core\Application\Interfaces\ServicioUsuarioInterface;
use App\Core\Domain\Entidades\Usuario;
use App\Core\Domain\Excepciones\UsuarioExcepcion;

class UsuarioServicio implements ServicioUsuarioInterface
{
  private RepositorioUsuarioInterface $repositorioUsuario;

  public function __construct(RepositorioUsuarioInterface $repositorioUsuario)
  {
    $this->repositorioUsuario = $repositorioUsuario;
  }

  public function obtenerTodos(): array
  {
    return $this->repositorioUsuario->obtenerTodos();
  }

  public function obtenerPorId(int $id): Usuario
  {
    $usuario = $this->repositorioUsuario->obtenerPorId($id);

    if (!$usuario) {
      throw UsuarioExcepcion::usuarioNoEncontrado((string) $id);
    }

    return $usuario;
  }

  public function obtenerPorUsuario(string $usuario): Usuario
  {
    $usuario = $this->repositorioUsuario->obtenerPorUsuario($usuario);

    if (!$usuario) {
      throw UsuarioExcepcion::usuarioNoEncontrado($usuario);
    }

    return $usuario;
  }

  public function crearUsuario(UsuarioDTO $usuarioDTO): Usuario
  {
    // Verificar si ya existe un usuario con ese nombre de usuario
    $usuarioExistente = $this->repositorioUsuario->obtenerPorUsuario($usuarioDTO->usuario);
    if ($usuarioExistente) {
      throw UsuarioExcepcion::usuarioYaExiste($usuarioDTO->usuario);
    }

    // Crear una nueva entidad de usuario
    $usuario = new Usuario(
      $usuarioDTO->usuario,
      $usuarioDTO->primerNombre,
      $usuarioDTO->segundoNombre,
      $usuarioDTO->primerApellido,
      $usuarioDTO->segundoApellido,
      $usuarioDTO->email,
      $usuarioDTO->departamentoId,
      $usuarioDTO->cargoId
    );

    // Guardar el usuario en el repositorio
    return $this->repositorioUsuario->guardar($usuario);
  }

  public function actualizarUsuario(int $id, UsuarioDTO $usuarioDTO): Usuario
  {
    // Verificar si el usuario existe
    $usuarioExistente = $this->repositorioUsuario->obtenerPorId($id);
    if (!$usuarioExistente) {
      throw UsuarioExcepcion::usuarioNoEncontrado((string) $id);
    }

    // Crear una entidad de usuario actualizada
    $usuarioActualizado = new Usuario(
      $usuarioDTO->usuario,
      $usuarioDTO->primerNombre,
      $usuarioDTO->segundoNombre,
      $usuarioDTO->primerApellido,
      $usuarioDTO->segundoApellido,
      $usuarioDTO->email,
      $usuarioDTO->departamentoId,
      $usuarioDTO->cargoId,
      $id
    );

    // Actualizar el usuario en el repositorio
    return $this->repositorioUsuario->actualizar($usuarioActualizado);
  }

  public function eliminarUsuario(int $id): bool
  {
    // Verificar si el usuario existe
    $usuarioExistente = $this->repositorioUsuario->obtenerPorId($id);
    if (!$usuarioExistente) {
      throw UsuarioExcepcion::usuarioNoEncontrado((string) $id);
    }

    // Eliminar el usuario del repositorio
    return $this->repositorioUsuario->eliminar($id);
  }
}