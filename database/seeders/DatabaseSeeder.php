<?php
// filepath: database/seeders/DatabaseSeeder.php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $profesorRole = Role::create(['name' => 'profesor']);
        $estudianteRole = Role::create(['name' => 'estudiante']);

        $profesor = User::create([
            'name' => 'Profesor',
            'email' => 'profesor@gmail.com',
            'password' => bcrypt('prueba'),
        ]);

        $profesor->assignRole($profesorRole);

        $estudiante = User::create([
            'name' => 'ignacio',
            'email' => 'ignacioverafernandez@gmail.com',
            'password' => bcrypt('nacho7304'),
        ]);

        $estudiante->assignRole($estudianteRole);
    }
}