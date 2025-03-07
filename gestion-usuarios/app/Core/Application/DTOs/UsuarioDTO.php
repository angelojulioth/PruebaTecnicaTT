<?php
// app/Core/Application/DTOs/UsuarioDTO.php

namespace App\Core\Application\DTOs;

class UsuarioDTO
{
  public string $usuario;
  public string $primerNombre;
  public ?string $segundoNombre;
  public string $primerApellido;
  public ?string $segundoApellido;
  public string $email;
  public int $departamentoId;
  public int $cargoId;

  public function __construct(
    string $usuario,
    string $primerNombre,
    ?string $segundoNombre,
    string $primerApellido,
    ?string $segundoApellido,
    string $email,
    int $departamentoId,
    int $cargoId
  ) {
    $this->usuario = $usuario;
    $this->primerNombre = $primerNombre;
    $this->segundoNombre = $segundoNombre;
    $this->primerApellido = $primerApellido;
    $this->segundoApellido = $segundoApellido;
    $this->email = $email;
    $this->departamentoId = $departamentoId;
    $this->cargoId = $cargoId;
  }

  public static function fromArray(array $data): self
  {
    return new self(
      $data['usuario'],
      $data['primer_nombre'],
      $data['segundo_nombre'] ?? null,
      $data['primer_apellido'],
      $data['segundo_apellido'] ?? null,
      $data['email'],
      $data['departamento_id'],
      $data['cargo_id']
    );
  }
}