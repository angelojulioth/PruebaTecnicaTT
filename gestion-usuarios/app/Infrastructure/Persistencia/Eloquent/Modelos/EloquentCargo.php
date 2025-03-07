<?php
// app/Infrastructure/Persistencia/Eloquent/Modelos/EloquentCargo.php

namespace App\Infrastructure\Persistencia\Eloquent\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentCargo extends Model
{
  use HasFactory;

  protected $table = 'cargos';

  protected $fillable = [
    'nombre',
  ];

  public function usuarios(): HasMany
  {
    return $this->hasMany(EloquentUsuario::class, 'cargo_id');
  }
}