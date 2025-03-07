<?php
// database/seeders/UsuarioSeeder.php

namespace Database\Seeders;

use App\Infrastructure\Persistencia\Eloquent\Modelos\EloquentUsuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
  public function run(): void
  {
    $usuarios = [
      [
        'usuario' => 'ppicapiedra',
        'primer_nombre' => 'Pedro',
        'segundo_nombre' => null,
        'primer_apellido' => 'Picapiedra',
        'segundo_apellido' => null,
        'email' => 'ppicapiedra@mail.com',
        'departamento_id' => 1, // Tecnologías de la Información
        'cargo_id' => 1, // Administrador
      ],
      [
        'usuario' => 'pmarmol',
        'primer_nombre' => 'Pablo',
        'segundo_nombre' => null,
        'primer_apellido' => 'Marmol',
        'segundo_apellido' => null,
        'email' => 'pmarmol@mail.com',
        'departamento_id' => 1, // Tecnologías de la Información
        'cargo_id' => 2, // Líder Frontend
      ],
      [
        'usuario' => 'jalimana',
        'primer_nombre' => 'Juanito',
        'segundo_nombre' => null,
        'primer_apellido' => 'Alimaña',
        'segundo_apellido' => null,
        'email' => 'jalimana@mail.com',
        'departamento_id' => 1, // Tecnologías de la Información
        'cargo_id' => 3, // Líder Backend
      ],
      [
        'usuario' => 'wwhite',
        'primer_nombre' => 'Walter',
        'segundo_nombre' => 'Hartwell',
        'primer_apellido' => 'White',
        'segundo_apellido' => 'Heisenberg',
        'email' => 'wwhite@mail.com',
        'departamento_id' => 1, // Tecnologías de la Información
        'cargo_id' => 4, // Desarrollador Frontend
      ],
      [
        'usuario' => 'jpinkman',
        'primer_nombre' => 'Jesse',
        'segundo_nombre' => null,
        'primer_apellido' => 'Pinkman',
        'segundo_apellido' => null,
        'email' => 'jpinkman@mail.com',
        'departamento_id' => 1, // Tecnologías de la Información
        'cargo_id' => 4, // Desarrollador Frontend
      ],
      [
        'usuario' => 'sgoodman',
        'primer_nombre' => 'Saul',
        'segundo_nombre' => null,
        'primer_apellido' => 'Goodman',
        'segundo_apellido' => null,
        'email' => 'sgoodman@mail.com',
        'departamento_id' => 2, // Legal
        'cargo_id' => 6, // Abogado
      ],
      [
        'usuario' => 'mehrmantraut',
        'primer_nombre' => 'Mike',
        'segundo_nombre' => null,
        'primer_apellido' => 'Ehrmantraut',
        'segundo_apellido' => null,
        'email' => 'mehrmantraut@mail.com',
        'departamento_id' => 3, // Seguridad
        'cargo_id' => 7, // Guardia
      ],
      [
        'usuario' => 'kwexler',
        'primer_nombre' => 'Kimberly',
        'segundo_nombre' => null,
        'primer_apellido' => 'Wexler',
        'segundo_apellido' => null,
        'email' => 'kwexler@mail.com',
        'departamento_id' => 2, // Legal
        'cargo_id' => 6, // Abogado
      ],
      [
        'usuario' => 'gfring',
        'primer_nombre' => 'Gustavo',
        'segundo_nombre' => null,
        'primer_apellido' => 'Fring',
        'segundo_apellido' => null,
        'email' => 'gfring@mail.com',
        'departamento_id' => 4, // Eventos y Buffets
        'cargo_id' => 8, // Pollero
      ],
    ];

    foreach ($usuarios as $usuario) {
      EloquentUsuario::create($usuario);
    }
  }
}