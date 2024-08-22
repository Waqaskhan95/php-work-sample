<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Plan::truncate();

        $plans = [
            [
                'role_id' => 2,
                'name' => 'Fan',
                'price' => 10,
                'content' => '<ul class="card-features"><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Stream on multiple devices </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Ad-free viewing experience </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Download to watch later </li></ul>'
            ],
            [
                'role_id' => 3,
                'name' => 'Athelete',
                'price' => 20,
                'content' => '<ul class="card-features"><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Stream on multiple devices </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Ad-free viewing experience </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Download to watch later </li></ul>'
            ],
            [
                'role_id' => 4,
                'name' => 'Corsacaster',
                'price' => 30,
                'content' => '<ul class="card-features"><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Stream on multiple devices </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Ad-free viewing experience </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Download to watch later </li></ul>'
            ],
            [
                'role_id' => 5,
                'name' => 'Guest',
                'price' => 30,
                'content' => '<ul class="card-features"><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Streaming in high quality </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Stream on multiple devices </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Ad-free viewing experience </li><li class="feature-item blur"><img src="https://toppng.com//public/uploads/preview/fancy-transparent-check-mark-11549995397zoza1ynyhw.png" style="width: 21px; height: 16px;" alt="Checkmark icon" class="feature-icon"> Download to watch later </li></ul>'
            ]
        ];
        

        foreach ($plans as $key => $plan) {
            Plan::create([
                'role_id' => $plan['role_id'],
                'name' => $plan['name'],
                'price' => $plan['price'],
                'content' => $plan['content']
            ]);
        }

        return true;
    }
}
