<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            'Small',
            'Medium',
            'Large',
            'XL',
            'XXL',
            'XXXL',
            'US 6',
            'US 7',
            'US 8',
            'US 9',
            'US 10',
            'EU 36',
            'EU 37',
            'EU 38',
            'EU 39',
            'EU 40',
            'EU 41',
            'EU 42',
            'EU 43',
        ];

        foreach ($sizes as $size) {
            DB::table('product_sizes')->insert([
                'name' => $size,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
