<?php
// app/Core/Domain/Entidades/Usuario.php

namespace App\Core\Domain\Entidades;

class Usuario
{
  private int $id;
  private string $usuario;
  private string $primerNombre;
  private ?string $segundoNombre;
  private string $primerApellido;
  private ?string $segundoApellido;
  private string $email;
  private int $departamentoId;
  private int $cargoId;

  public function __construct(
    string $usuario,
    string $primerNombre,
    ?string $segundoNombre,
    string $primerApellido,
    ?string $segundoApellido,
    string $email,
    int $departamentoId,
    int $cargoId,
    ?int $id = null
  ) {
    $this->usuario = $usuario;
    $this->primerNombre = $primerNombre;
    $this->segundoNombre = $segundoNombre;
    $this->primerApellido = $primerApellido;
    $this->segundoApellido = $segundoApellido;
    $this->email = $email;
    $this->departamentoId = $departamentoId;
    $this->cargoId = $cargoId;

    if ($id) {
      $this->id = $id;
    }
  }

  // Getters
  public function getId(): ?int
  {
    return $this->id ?? null;
  }

  public function getUsuario(): string
  {
    return $this->usuario;
  }

  public function getPrimerNombre(): string
  {
    return $this->primerNombre;
  }

  public function getSegundoNombre(): ?string
  {
    return $this->segundoNombre;
  }

  public function getPrimerApellido(): string
  {
    return $this->primerApellido;
  }

  public function getSegundoApellido(): ?string
  {
    return $this->segundoApellido;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getDepartamentoId(): int
  {
    return $this->departamentoId;
  }

  public function getCargoId(): int
  {
    return $this->cargoId;
  }

  // Método para obtener el nombre completo
  public function getNombreCompleto(): string
  {
    $nombreCompleto = $this->primerNombre;

    if ($this->segundoNombre) {
      $nombreCompleto .= " {$this->segundoNombre}";
    }

    $nombreCompleto .= " {$this->primerApellido}";

    if ($this->segundoApellido) {
      $nombreCompleto .= " {$this->segundoApellido}";
    }

    return $nombreCompleto;
  }
}