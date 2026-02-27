<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['categorie' => 'UI Kit'],
            ['categorie' => 'Template'],
            ['categorie' => 'Plugin'],
            ['categorie' => 'Cours'],
            ['categorie' => 'Illustration'],
            ['categorie' => 'Audio'],
            ['categorie' => 'Vidéo'],
            ['categorie' => 'Bundle'],
            ['categorie' => '3D'],
            ['categorie' => 'Autre'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['categorie' => $category['categorie']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
