<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin RentaCar',
                'email' => 'admin@rentacar.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Lucía Fernández',
                'email' => 'lucia@rentacar.test',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Martín Gómez',
                'email' => 'martin@rentacar.test',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }
    }
}
