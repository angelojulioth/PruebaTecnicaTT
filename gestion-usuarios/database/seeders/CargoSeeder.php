<?php
// database/seeders/CargoSeeder.php

namespace Database\Seeders;

use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentCargo;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
  public function run(): void
  {
    $cargos = [
      ['nombre' => 'Administrador'],
      ['nombre' => 'Líder Frontend'],
      ['nombre' => 'Líder Backend'],
      ['nombre' => 'Desarrollador Frontend'],
      ['nombre' => 'Desarrollador Backend'],
      ['nombre' => 'Abogado'],
      ['nombre' => 'Guardia'],
      ['nombre' => 'Pollero'],
    ];

    foreach ($cargos as $cargo) {
      EloquentCargo::create($cargo);
    }
  }
}