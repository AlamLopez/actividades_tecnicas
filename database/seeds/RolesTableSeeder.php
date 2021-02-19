<?php

use Illuminate\Database\Seeder;
use App\Rol;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Rol::create([
            'nombre' => 'ADMINISTRADOR',
            'descripcion' => 'Administrador del sistema'
        ]);

        Rol::create([
            'nombre' => 'MONITOREO',
            'descripcion' => 'Monitoreo de GPS y actividades técnicas'
        ]);

        Rol::create([
            'nombre' => 'OPERATIVO',
            'descripcion' => 'Departamento de operaciones'
        ]);

        Rol::create([
            'nombre' => 'TÉCNICO',
            'descripcion' => 'Departamento técnico'
        ]);

        Rol::create([
            'nombre' => 'ATENCIÓN AL CLIENTE',
            'descripcion' => 'Atención al cliente'
        ]);

        Rol::create([
            'nombre' => 'PRUEBAS',
            'descripcion' => 'Usuario para pruebas'
        ]);


    }
}
