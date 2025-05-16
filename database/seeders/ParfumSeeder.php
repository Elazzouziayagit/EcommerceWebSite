<?php

namespace Database\Seeders;

use App\Models\Parfum;
use Illuminate\Database\Seeder;

class ParfumSeeder extends Seeder
{
    public function run()
    {
        $parfums = [
            [
                'nom' => 'Bleu de Chanel',
                'description' => 'Un parfum boisé aromatique pour homme, avec des notes de citron, de menthe, de gingembre et de bois de santal.',
                'prix' => 89.99,
                'stock' => 50,
                'image' => null,
                'id_categorie' => 1,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Coco Mademoiselle',
                'description' => 'Un parfum oriental frais pour femme, avec des notes d\'orange, de jasmin et de patchouli.',
                'prix' => 99.99,
                'stock' => 45,
                'image' => null,
                'id_categorie' => 2,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Sauvage',
                'description' => 'Un parfum frais et boisé pour homme, avec des notes de bergamote, de poivre et d\'ambroxan.',
                'prix' => 79.99,
                'stock' => 60,
                'image' => null,
                'id_categorie' => 1,
                'date_ajout' => now()
            ],
            [
                'nom' => 'La Vie Est Belle',
                'description' => 'Un parfum gourmand floral pour femme, avec des notes d\'iris, de jasmin et de praline.',
                'prix' => 85.99,
                'stock' => 40,
                'image' => null,
                'id_categorie' => 2,
                'date_ajout' => now()
            ],
            [
                'nom' => 'CK One',
                'description' => 'Un parfum frais et citronné unisexe, avec des notes de bergamote, de cardamome et de musc.',
                'prix' => 59.99,
                'stock' => 70,
                'image' => null,
                'id_categorie' => 3,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Acqua di Giò',
                'description' => 'Un parfum aquatique aromatique pour homme, avec des notes de bergamote, de néroli et de bois de cèdre.',
                'prix' => 75.99,
                'stock' => 55,
                'image' => null,
                'id_categorie' => 1,
                'date_ajout' => now()
            ],
            [
                'nom' => 'J\'adore',
                'description' => 'Un parfum floral fruité pour femme, avec des notes de mandarine, de jasmin et de rose.',
                'prix' => 95.99,
                'stock' => 35,
                'image' => null,
                'id_categorie' => 2,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Le Male',
                'description' => 'Un parfum oriental fougère pour homme, avec des notes de lavande, de menthe et de vanille.',
                'prix' => 69.99,
                'stock' => 65,
                'image' => null,
                'id_categorie' => 1,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Black Opium',
                'description' => 'Un parfum gourmand floral pour femme, avec des notes de café, de vanille et de fleur d\'oranger.',
                'prix' => 92.99,
                'stock' => 30,
                'image' => null,
                'id_categorie' => 2,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Terre d\'Hermès',
                'description' => 'Un parfum boisé épicé pour homme, avec des notes d\'orange, de poivre et de vétiver.',
                'prix' => 88.99,
                'stock' => 40,
                'image' => null,
                'id_categorie' => 1,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Chance',
                'description' => 'Un parfum floral aldéhydé pour femme, avec des notes de jasmin, d\'iris et de musc.',
                'prix' => 87.99,
                'stock' => 38,
                'image' => null,
                'id_categorie' => 2,
                'date_ajout' => now()
            ],
            [
                'nom' => 'Aventus',
                'description' => 'Un parfum fruité chypré pour homme, avec des notes d\'ananas, de cassis et de bois de cèdre.',
                'prix' => 299.99,
                'stock' => 15,
                'image' => null,
                'id_categorie' => 4,
                'date_ajout' => now()
            ]
        ];

        foreach ($parfums as $parfum) {
            Parfum::create($parfum);
        }
    }
}