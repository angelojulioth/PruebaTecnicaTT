<?php
// app/Core/Domain/Excepciones/UsuarioExcepcion.php

namespace App\Core\Domain\Excepciones;

use Exception;

class UsuarioExcepcion extends Exception
{
  public static function usuarioNoEncontrado(string $usuario): self
  {
    return new self("Usuario con identificador {$usuario} no encontrado");
  }

  public static function emailYaExiste(string $email): self
  {
    return new self("El email {$email} ya está en uso");
  }

  public static function usuarioYaExiste(string $usuario): self
  {
    return new self("El nombre de usuario {$usuario} ya está en uso");
  }
}