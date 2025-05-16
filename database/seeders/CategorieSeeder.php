<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'nom' => 'Parfums Homme',
                'description' => 'Parfums et eaux de toilette pour homme'
            ],
            [
                'nom' => 'Parfums Femme',
                'description' => 'Parfums et eaux de toilette pour femme'
            ],
            [
                'nom' => 'Parfums Unisexe',
                'description' => 'Parfums et eaux de toilette unisexe'
            ],
            [
                'nom' => 'Collections Exclusives',
                'description' => 'Parfums de luxe et collections limitées'
            ],
            [
                'nom' => 'Coffrets Cadeaux',
                'description' => 'Coffrets et ensembles cadeaux'
            ]
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}