<?php
// app/Core/Application/Interfaces/RepositorioUsuarioInterface.php

namespace App\Core\Application\Interfaces;

use App\Core\Domain\Entidades\Usuario;

interface RepositorioUsuarioInterface
{
  public function obtenerTodos(): array;
  public function obtenerPorId(int $id): ?Usuario;
  public function obtenerPorUsuario(string $usuario): ?Usuario;
  public function guardar(Usuario $usuario): Usuario;
  public function actualizar(Usuario $usuario): Usuario;
  public function eliminar(int $id): bool;
}