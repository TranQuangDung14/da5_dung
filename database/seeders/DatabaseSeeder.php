<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            category_productSeeder::class,
            // status_Seeder::class,
            UserSeeder::class,
            Type_postSeeder::class,
            imageSeeder::class,
            PostSeeder::class,
            ProductSeeder::class,

        ]);
    }
}
