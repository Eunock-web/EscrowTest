<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first creator or admin to assign products to
        $creator = User::where('role', 'createur')->first()
            ?? User::where('role', 'admin')->first();

        if (! $creator) {
            $this->command->warn('No creator found. Skipping ProductSeeder.');

            return;
        }

        $categories = Categorie::all()->keyBy('categorie');

        $getCatId = fn (string $name) => optional($categories->get($name))->id ?? $categories->first()->id;

        $products = [
            [
                'nom' => 'Pack UI Kit Dark Mode',
                'description' => "Un pack complet de composants UI en mode sombre, prêts à l'emploi pour vos projets Figma et React. Inclut plus de 200 composants soigneusement conçus avec des variantes et des états interactifs.",
                'prix' => 12500,
                'stock' => 4,
                'categories' => 'UI Kit',
                'url_image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800',
                'categorie_id' => $getCatId('UI Kit'),
            ],
            [
                'nom' => 'Template Dashboard Laravel 12',
                'description' => 'Template complet de dashboard admin avec Laravel 12, Blade, TailwindCSS et Livewire. Authentification, CRUD, graphiques et gestion des rôles inclus. Parfait pour démarrer rapidement.',
                'prix' => 25000,
                'stock' => 9,
                'categories' => 'Template',
                'url_image' => 'https://images.unsplash.com/photo-1555421689-d68471e189f2?w=800',
                'categorie_id' => $getCatId('Template'),
            ],
            [
                'nom' => "Pack d'icônes Minimalistes SVG",
                'description' => '500 icônes SVG minimalistes dans 3 styles (outline, filled, duotone). Livrées en SVG, PNG et en composants React/Vue. Licence commerciale incluse, mises à jour gratuites à vie.',
                'prix' => 8000,
                'stock' => 5,
                'categories' => 'Illustration',
                'url_image' => 'https://images.unsplash.com/photo-1509051943-64aaab7b9fe3?w=800',
                'categorie_id' => $getCatId('Illustration'),
            ],
            [
                'nom' => 'Cours Complet : Motion Design After Effects',
                'description' => 'Formation complète pour maîtriser After Effects de zéro à avancé. 12 heures de vidéo HD, fichiers sources inclus, certificat de complétion. Apprenez à créer des animations professionnelles.',
                'prix' => 35000,
                'stock' => 5,
                'categories' => 'Courrs',
                'url_image' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=800',
                'categorie_id' => $getCatId('Cours'),
            ],
            [
                'nom' => 'Kit de Sons Ambient Lofi',
                'description' => 'Collection de 80 sons ambient et lofi pour vos projets vidéo, podcasts ou streams. Incluant pluie, café, nature et ambiances urbaines. Tous les sons sont libres de droits pour usage commercial.',
                'prix' => 6500,
                'stock' => 3,
                'categories' => 'Audio',
                'url_image' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=800',
                'categorie_id' => $getCatId('Audio'),
            ],
            [
                'nom' => 'Template Figma — Portfolio Créatif',
                'description' => 'Template Figma premium pour créateurs et designers. 15 pages entièrement personnalisables, grilles typographiques, composants auto-layout et guide de style complet. Export responsive inclus.',
                'prix' => 9500,
                'stock' => 2,
                'categories' => 'Template',
                'url_image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800',
                'categorie_id' => $getCatId('Template'),
            ],
            [
                'nom' => 'API REST Go Lang — Boilerplate',
                'description' => "Boilerplate d'API REST production-ready avec Go, JWT, PostgreSQL, Docker et CI/CD préconfiguré. Documentation Swagger incluse, tests unitaires couvrant 80% du code.",
                'prix' => 18000,
                'stock' => 7,
                'categories' => 'Bundle',
                'url_image' => 'https://images.unsplash.com/photo-1518432031352-d6fc5c10da5a?w=800',
                'categorie_id' => $getCatId('Bundle'),
            ],
        ];

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['nom' => $productData['nom'], 'user_id' => $creator->id],
                array_merge($productData, ['user_id' => $creator->id])
            );
        }
    }
}
