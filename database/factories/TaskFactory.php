<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       $price = [300,500,800,1500];
       $status = ['pending','complete'];
       $name = $this->faker->sentence();
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->sentences(rand(2,5),true),
            'price'=> $price[rand(0,3)],
            'status'=> $status[rand(0,1)],
            'client_id'=> Client::all()->random()->id,
            'user_id'=> User::all()->random()->id,
        ];
    }
}
