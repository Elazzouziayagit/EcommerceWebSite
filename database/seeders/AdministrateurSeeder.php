<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    public function run()
    {
        Administrateur::firstOrCreate(
            ['email' => 'admin@parfumerie.com'], // Critère de recherche
            [
                'nom' => 'Admin Principal',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'super admin',
                'date_creation' => now()
            ]
        );
    }
}
