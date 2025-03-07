<?php
// app/Infrastructure/Persistencia/Eloquent/Modelos/EloquentUsuario.php

namespace App\Infrastructure\Persistencia\Eloquent\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentUsuario extends Model
{
  use HasFactory;

  protected $table = 'usuarios';

  protected $fillable = [
    'usuario',
    'primer_nombre',
    'segundo_nombre',
    'primer_apellido',
    'segundo_apellido',
    'email',
    'departamento_id',
    'cargo_id',
  ];

  public function departamento(): BelongsTo
  {
    return $this->belongsTo(EloquentDepartamento::class, 'departamento_id');
  }

  public function cargo(): BelongsTo
  {
    return $this->belongsTo(EloquentCargo::class, 'cargo_id');
  }
}