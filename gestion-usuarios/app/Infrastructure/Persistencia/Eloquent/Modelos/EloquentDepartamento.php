<?php
// app/Infrastructure/Persistencia/Eloquent/Modelos/EloquentDepartamento.php

namespace App\Infrastructure\Persistencia\Eloquent\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentDepartamento extends Model
{
  use HasFactory;

  protected $table = 'departamentos';

  protected $fillable = [
    'nombre',
  ];

  public function usuarios(): HasMany
  {
    return $this->hasMany(EloquentUsuario::class, 'departamento_id');
  }
}