<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            [
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'mot_de_passe' => Hash::make('password'),
                'adresse' => '15 rue de Paris, 75001 Paris',
                'telephone' => '0123456789',
                'date_inscription' => now()
            ],
            [
                'nom' => 'Marie Martin',
                'email' => 'marie.martin@example.com',
                'mot_de_passe' => Hash::make('password'),
                'adresse' => '25 avenue des Champs-Élysées, 75008 Paris',
                'telephone' => '0987654321',
                'date_inscription' => now()
            ],
            [
                'nom' => 'Pierre Durand',
                'email' => 'pierre.durand@example.com',
                'mot_de_passe' => Hash::make('password'),
                'adresse' => '5 place Bellecour, 69002 Lyon',
                'telephone' => '0654321987',
                'date_inscription' => now()
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}