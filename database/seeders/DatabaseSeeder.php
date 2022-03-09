<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use App\Models\Invoice;
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
       User::create([
           'name'=>'sajib saha',
           'email'=>'a@a.com',
           'company' => 'Sajib Corp',
           'phone'  => '+8801745705857',
           'country' => 'Bangladesh',
           'password'=>bcrypt('123'),
           'thumbnail'=>'https://picsum.photos/300'
       ]);
//       User::create([
//        'name'=>'demo user',
//        'email'=>'c@c.com',
//        'company' => 'Sajib Corp',
//        'phone'  => '+8801745705857',
//        'country' => 'Bangladesh',
//        'password'=>bcrypt('123'),
//        'thumbnail'=>'https://picsum.photos/300'
//        ]);

       Client::factory(5)->create();

       Task::factory(30)->create();

      // Invoice::factory(10)->create();
    }
}
