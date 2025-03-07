<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->getId(),
      'usuario' => $this->getUsuario(),
      'nombres' => $this->getPrimerNombre() . ($this->getSegundoNombre() ? ' ' . $this->getSegundoNombre() : ''),
      'primer_nombre' => $this->getPrimerNombre(),
      'segundo_nombre' => $this->getSegundoNombre(),
      'apellidos' => $this->getPrimerApellido() . ($this->getSegundoApellido() ? ' ' . $this->getSegundoApellido() : ''),
      'primer_apellido' => $this->getPrimerApellido(),
      'segundo_apellido' => $this->getSegundoApellido(),
      'email' => $this->getEmail(),
      'departamento_id' => $this->getDepartamentoId(),
      'cargo_id' => $this->getCargoId(),
    ];
  }
}