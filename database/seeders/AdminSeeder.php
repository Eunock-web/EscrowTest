<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pixelvault.com'],
            [
                'firstname' => 'Admin',
                'lastname' => 'Pixel',
                'pseudo' => 'AdminVault',
                'description' => 'Administrateur de la plateforme PixelVault.',
                'role' => 'admin',
                'isAuth' => true,
                'password' => Hash::make('PassW@rd'),
            ]
        );
    }
}
