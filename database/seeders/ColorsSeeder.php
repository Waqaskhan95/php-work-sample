<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            'White',
            'Black',
            'Red',
            'Blue',
            'Green',
            'Yellow',
            'Orange',
            'Pink',
            'Purple',
            'Brown',
            'Gray',
            'Silver',
            'Gold',
            'Bronze',
            'Beige',
            'Turquoise',
            'Teal',
            'Navy',
            'Olive',
            'Maroon',
        ];

        foreach ($colors as $color) {
            DB::table('product_colors')->insert([
                'name' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
