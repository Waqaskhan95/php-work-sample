<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleTypes;

class RoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        RoleTypes::truncate();

        $types = [
        [ 
          'name' => 'Freelancer',
        ],
        [
          'name' => 'Team Creator',
        ],
        [
          'name' => 'Venue',
        ],
        [
          'name' => 'Promoter',
        ]
      ];

      foreach ($types as $key => $type) {
        RoleTypes::create([
          'name' => $type['name']
        ]);
      }
    }
}
