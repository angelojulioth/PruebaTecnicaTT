<?php
// app/Http/Requests/ActualizarUsuarioRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarUsuarioRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'usuario' => [
        'required',
        'string',
        'max:50',
        Rule::unique('usuarios', 'usuario')->ignore($this->route('usuario'))
      ],
      'primer_nombre' => 'required|string|max:100',
      'segundo_nombre' => 'nullable|string|max:100',
      'primer_apellido' => 'required|string|max:100',
      'segundo_apellido' => 'nullable|string|max:100',
      'email' => [
        'required',
        'email',
        'max:100',
        Rule::unique('usuarios', 'email')->ignore($this->route('usuario'))
      ],
      'departamento_id' => 'required|integer|exists:departamentos,id',
      'cargo_id' => 'required|integer|exists:cargos,id',
    ];
  }

  public function messages(): array
  {
    return [
      'usuario.required' => 'El nombre de usuario es obligatorio',
      'usuario.unique' => 'Este nombre de usuario ya está en uso',
      'primer_nombre.required' => 'El primer nombre es obligatorio',
      'primer_apellido.required' => 'El primer apellido es obligatorio',
      'email.required' => 'El correo electrónico es obligatorio',
      'email.email' => 'Formato de correo electrónico inválido',
      'email.unique' => 'Este correo electrónico ya está en uso',
      'departamento_id.required' => 'El departamento es obligatorio',
      'departamento_id.exists' => 'El departamento seleccionado no existe',
      'cargo_id.required' => 'El cargo es obligatorio',
      'cargo_id.exists' => 'El cargo seleccionado no existe',
    ];
  }
}