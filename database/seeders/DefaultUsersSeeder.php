<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'nombre' => 'admin',
            'apellido' => 'apellido1',
            'cedula' => '1234567890',
            'ciudad' => 'Ciudad1',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'admin@correo.com',
            'usuario' => 'admin',
            'rol' => 'admin',
            'password' => Hash::make('47@t8h"8~GJm'),
        ]);

        // Usuario 1
        User::create([
            'nombre' => 'Jhon',
            'apellido' => 'Doe',
            'cedula' => '0987654321',
            'ciudad' => 'Ciudad2',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'user@correo.com',
            'usuario' => 'user_1',
            'rol' => 'cliente',
            'password' => Hash::make('47@t8h"8~GJm'),
        ]);

        // Usuario 2
        User::create([
            'nombre' => 'Laura',
            'apellido' => 'Smith',
            'cedula' => '1122334455',
            'ciudad' => 'Ciudad2',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'user2@correo.com',
            'usuario' => 'user',
            'rol' => 'cliente',
            'password' => Hash::make('47@t8h"8~GJm'),
        ]);
    }
}
