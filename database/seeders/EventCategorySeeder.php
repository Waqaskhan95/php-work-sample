<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $categories = [
            [ 
              'name'    => 'Road',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'Track',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'MTB',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'Criterium',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'Cyclocross',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'BMX',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
            [ 
              'name'    => 'Gravel',
              'status'  => 1,
              'parent'  => 0,
              'type'    => 'event'
            ],
        ];

        
      foreach ($categories as $key => $category) {
        Category::create([
          'name' => $category['name'],
          'status' => $category['status'],
          'parent' => $category['parent'],
          'type' => $category['type']
        ]);
      }
    }
}
