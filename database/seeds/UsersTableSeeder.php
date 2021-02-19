<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'usuario' => 'admin',
            'email' => 'administrador@grupodisatel.com',
            'nombrecompleto' => 'ADMINISTRADOR',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 1
        ]);

        User::create([
            'usuario' => 'monitoreo',
            'email' => 'monitoreo@grupodisatel.com',
            'nombrecompleto' => 'MONITOREO',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 2
        ]);

        User::create([
            'usuario' => 'henry',
            'email' => 'henry.bolaños@grupodisatel.com',
            'nombrecompleto' => 'HENRY BOLAÑOS',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 5
        ]);

        User::create([
            'usuario' => 'marvin',
            'email' => 'marvin.ramirez@grupodisatel.com',
            'nombrecompleto' => 'MARVIN RAMIREZ',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 5
        ]);

        User::create([
            'usuario' => 'portillo',
            'email' => 'roberto.portillo@grupodisatel.com',
            'nombrecompleto' => 'ROBERTO PORTILLO',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 5
        ]);

        User::create([
            'usuario' => 'prueba',
            'email' => 'pruebas@grupodisatel.com',
            'nombrecompleto' => 'NO ASIGNADO',
            'password' => bcrypt('admin123'),
            'condicion' => true,
            'idrol' => 6
        ]);
        
    }
}
