<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class PopulateUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=PopulateUsersTableSeeder
        
        $faker = Faker\Factory::create();

        User::create([  'username'      => 'goodman',
                        'name'          => 'Saul',
                        'lastName'      => 'Goodman',
                        'email'         => 'saul.goodman@chh.com',
                        'password'      => \Hash::make('goodlawyer')
                    ]);

        for($i = 0; $i < 100; $i++) 
        {
            User::create([  'username'      => $faker->userName,
                            'name'          => $faker->firstName,
                            'lastName'      => $faker->lastName,
                            'email'         => $faker->email,
                            'password'      => \Hash::make('superpassword')
                        ]);
            //print_r($user);
        }
    }
}