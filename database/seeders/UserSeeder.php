<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin RentaCar',
                'email' => 'admin@rentacar.test',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Cliente Demo',
                'email' => 'cliente@rentacar.test',
                'password' => 'password',
                'role' => 'user',
            ],
            [
                'name' => 'Lucía Fernández',
                'email' => 'lucia@rentacar.test',
                'password' => 'password',
                'role' => 'user',
            ],
            [
                'name' => 'Martín Gómez',
                'email' => 'martin@rentacar.test',
                'password' => 'password',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }
    }
}
