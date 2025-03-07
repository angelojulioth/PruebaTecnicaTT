<?php
// database/seeders/DepartamentoSeeder.php

namespace Database\Seeders;

use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentDepartamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
  public function run(): void
  {
    $departamentos = [
      ['nombre' => 'Tecnologías de la Información'],
      ['nombre' => 'Legal'],
      ['nombre' => 'Seguridad'],
      ['nombre' => 'Eventos y Buffets'],
      ['nombre' => 'Recursos Humanos'],
    ];

    foreach ($departamentos as $departamento) {
      EloquentDepartamento::create($departamento);
    }
  }
}