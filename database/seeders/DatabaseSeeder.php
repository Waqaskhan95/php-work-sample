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
        $this->call([BrandSeeder::class, CategorySeeder::class, CountriesTableSeeder::class, CitiesTableChunkOneSeeder::class, CitiesTableChunkTwoSeeder::class, CitiesTableChunkThreeSeeder::class, CitiesTableChunkFourSeeder::class, CitiesTableChunkFiveSeeder::class, StatesTableSeeder::class, ColorsSeeder::class, EventCategorySeeder::class, PlanSeeder::class, ProductSizesTableSeeder::class, RoleSeeder::class, RoleTypeSeeder::class, ]);
    }
}
