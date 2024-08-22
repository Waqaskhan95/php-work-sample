<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categories = [
        [ 
          'name'    => 'Sportswear and Apparel',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Fitness Equipment',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Nutritional Supplements',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports Accessories',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Recovery and Injury Prevention',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports Technology',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Sport-specific Equipment',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Protective Gear',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Outdoor Gear',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Training and Coaching Resources',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Fan Merchandise',
          'status'  => 1,
          'parent'  => 0,
          'type'    => 'product'
        ],
        [
          'name' => 'Athletic clothing',
          'status'  => 1,
          'parent'  => 1,
          'type'    => 'product'
        ],
        [
          'name' => 'Running shoes',
          'status'  => 1,
          'parent'  => 1,
          'type'    => 'product'
        ],
        [
          'name' => 'Training shoes',
          'status'  => 1,
          'parent'  => 1,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports bras',
          'status'  => 1,
          'parent'  => 1,
          'type'    => 'product'
        ],
        [
          'name' => 'Compression socks and sleeves',
          'status'  => 1,
          'parent'  => 1,
          'type'    => 'product'
        ],
        [
          'name' => 'Dumbbells and free weights',
          'status'  => 1,
          'parent'  => 2,
          'type'    => 'product'
        ],
        [
          'name' => 'Resistance bands',
          'status'  => 1,
          'parent'  => 2,
          'type'    => 'product'
        ],
        [
          'name' => 'Treadmills',
          'status'  => 1,
          'parent'  => 2,
          'type'    => 'product'
        ],
        [
          'name' => 'Exercise bikes',
          'status'  => 1,
          'parent'  => 2,
          'type'    => 'product'
        ],
        [
          'name' => 'Yoga mats and accessories',
          'status'  => 1,
          'parent'  => 2,
          'type'    => 'product'
        ],
        [
          'name' => 'Protein powders',
          'status'  => 1,
          'parent'  => 3,
          'type'    => 'product'
        ],
        [
          'name' => 'Energy bars and gels',
          'status'  => 1,
          'parent'  => 3,
          'type'    => 'product'
        ],
        [
          'name' => 'Amino acids',
          'status'  => 1,
          'parent'  => 3,
          'type'    => 'product'
        ],
        [
          'name' => 'Multivitamins',
          'status'  => 1,
          'parent'  => 3,
          'type'    => 'product'
        ],
        [
          'name' => 'Creatine',
          'status'  => 1,
          'parent'  => 3,
          'type'    => 'product'
        ],
        [
          'name' => 'Water bottles and hydration systems',
          'status'  => 1,
          'parent'  => 4,
          'type'    => 'product'
        ],
        [
          'name' => 'Gym bags',
          'status'  => 1,
          'parent'  => 4,
          'type'    => 'product'
        ],
        [
          'name' => 'Fitness trackers',
          'status'  => 1,
          'parent'  => 4,
          'type'    => 'product'
        ],
        [
          'name' => 'Heart rate monitors',
          'status'  => 1,
          'parent'  => 4,
          'type'    => 'product'
        ],
        [
          'name' => 'Workout gloves and grips',
          'status'  => 1,
          'parent'  => 4,
          'type'    => 'product'
        ],
        [
          'name' => 'Foam rollers',
          'status'  => 1,
          'parent'  => 5,
          'type'    => 'product'
        ],
        [
          'name' => 'Massage guns',
          'status'  => 1,
          'parent'  => 5,
          'type'    => 'product'
        ],
        [
          'name' => 'Ice packs',
          'status'  => 1,
          'parent'  => 5,
          'type'    => 'product'
        ],
        [
          'name' => 'Compression sleeves',
          'status'  => 1,
          'parent'  => 5,
          'type'    => 'product'
        ],
        [
          'name' => 'KT tape and athletic tape',
          'status'  => 1,
          'parent'  => 5,
          'type'    => 'product'
        ],
        [
          'name' => 'Smartwatches for tracking workouts',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'GPS running watches',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'Action cameras for recording sports activities',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'Action cameras for recording sports activities',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'Fitness apps and software',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'Performance analytics tools',
          'status'  => 1,
          'parent'  => 6,
          'type'    => 'product'
        ],
        [
          'name' => 'Tennis rackets and balls',
          'status'  => 1,
          'parent'  => 7,
          'type'    => 'product'
        ],
        [
          'name' => 'Golf clubs and accessories',
          'status'  => 1,
          'parent'  => 7,
          'type'    => 'product'
        ],
        [
          'name' => 'Basketball, soccer, and other sport balls',
          'status'  => 1,
          'parent'  => 7,
          'type'    => 'product'
        ],
        [
          'name' => 'Surfboards and wetsuits',
          'status'  => 1,
          'parent'  => 7,
          'type'    => 'product'
        ],
        [
          'name' => 'Skiing and snowboarding gear',
          'status'  => 1,
          'parent'  => 7,
          'type'    => 'product'
        ],
        [
          'name' => 'Helmets for various sports',
          'status'  => 1,
          'parent'  => 8,
          'type'    => 'product'
        ],
        [
          'name' => 'Mouthguards',
          'status'  => 1,
          'parent'  => 8,
          'type'    => 'product'
        ],
        [
          'name' => 'Shin guards',
          'status'  => 1,
          'parent'  => 8,
          'type'    => 'product'
        ],
        [
          'name' => 'Pads and braces',
          'status'  => 1,
          'parent'  => 8,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports-specific goggles and eyewear',
          'status'  => 1,
          'parent'  => 8,
          'type'    => 'product'
        ],
        [
          'name' => 'Hiking boots and gear',
          'status'  => 1,
          'parent'  => 9,
          'type'    => 'product'
        ],
        [
          'name' => 'Camping equipment',
          'status'  => 1,
          'parent'  => 9,
          'type'    => 'product'
        ],
        [
          'name' => 'Climbing harnesses and ropes',
          'status'  => 1,
          'parent'  => 9,
          'type'    => 'product'
        ],
        [
          'name' => 'Biking helmets and accessories',
          'status'  => 1,
          'parent'  => 9,
          'type'    => 'product'
        ],
        [
          'name' => 'Kayaks and paddles',
          'status'  => 1,
          'parent'  => 9,
          'type'    => 'product'
        ],
        [
          'name' => 'Books and DVDs on sports training',
          'status'  => 1,
          'parent'  => 10,
          'type'    => 'product'
        ],
        [
          'name' => 'Online training programs',
          'status'  => 1,
          'parent'  => 10,
          'type'    => 'product'
        ],
        [
          'name' => 'Coaching services',
          'status'  => 1,
          'parent'  => 10,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports medicine books and resources',
          'status'  => 1,
          'parent'  => 10,
          'type'    => 'product'
        ],
        [
          'name' => 'Mental training and mindfulness resources',
          'status'  => 1,
          'parent'  => 10,
          'type'    => 'product'
        ],
        [
          'name' => 'Sports team jerseys and memorabilia',
          'status'  => 1,
          'parent'  => 11,
          'type'    => 'product'
        ],
        [
          'name' => 'Fan gear (hats, scarves, foam fingers)',
          'status'  => 1,
          'parent'  => 11,
          'type'    => 'product'
        ],
        [
          'name' => 'Posters and wall art',
          'status'  => 1,
          'parent'  => 11,
          'type'    => 'product'
        ],
        [
          'name' => 'Collectibles and trading cards',
          'status'  => 1,
          'parent'  => 11,
          'type'    => 'product'
        ]
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
