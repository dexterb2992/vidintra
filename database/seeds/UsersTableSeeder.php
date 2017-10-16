<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::truncate();

        User::create([
            'id' => 1,
            'name' => "Dexter Bengil",
            'email' => "dexterb2992@gmail.com",
            'password' => bcrypt('dexter'),
            'api_token' => str_random(60)
        ]);

        foreach (range(1, 10) as $i) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'api_token' => str_random(60)
            ]);
        }
    }
}
