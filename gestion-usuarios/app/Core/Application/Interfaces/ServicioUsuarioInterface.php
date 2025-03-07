<?php
// app/Core/Application/Interfaces/ServicioUsuarioInterface.php

namespace App\Core\Application\Interfaces;

use App\Core\Application\DTOs\UsuarioDTO;
use App\Core\Domain\Entidades\Usuario;

interface ServicioUsuarioInterface
{
  public function obtenerTodos(): array;
  public function obtenerPorId(int $id): Usuario;
  public function obtenerPorUsuario(string $usuario): Usuario;
  public function crearUsuario(UsuarioDTO $usuarioDTO): Usuario;
  public function actualizarUsuario(int $id, UsuarioDTO $usuarioDTO): Usuario;
  public function eliminarUsuario(int $id): bool;
}