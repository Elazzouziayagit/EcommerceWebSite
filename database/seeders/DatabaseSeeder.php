<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdministrateurSeeder::class,
            CategorieSeeder::class,
            ParfumSeeder::class,
            ClientSeeder::class,
        ]);
    }
}