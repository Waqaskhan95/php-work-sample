<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::truncate();

        $brands = [
        [ 
          'name' => 'Nike',
        ],
        [
          'name' => 'Adidas',
        ],
        [
          'name' => 'Under Armour',
        ],
        [
          'name' => 'Reebok',
        ],
        [
          'name' => 'Puma',
        ],
        [
          'name' => 'Asics',
        ],
        [
          'name' => 'Oakley',
        ],
        [
          'name' => 'Wilson',
        ],
        [
          'name' => 'Burton',
        ],
        [
          'name' => 'Gore-Tex',
        ]
      ];

      foreach ($brands as $key => $brand) {
        Brand::create([
          'name' => $brand['name']
        ]);
      }


    }
}
