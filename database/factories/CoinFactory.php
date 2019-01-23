<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Coin::class, function (Faker $faker, $params) {
    $rank = isset($params['rank']) ? $params['rank'] : null;
    return [
            'name'                  => $faker->name,
            'symbol'                => str_random(3),
            'logo'                  => '',
            'rank'                  => !empty($rank) ? $rank : $faker->unique()->randomDigitNotNull(),
            'price_usd'             => $faker->randomFloat(20, -1000, 5000),
            'price_btc'             => null,
            '24h_volume_usd'        => $faker->randomFloat(20, -1000, 5000),
            'market_cap_usd'        => $faker->randomFloat(20, -1000, 5000),
            'available_supply'      => $faker->randomFloat(20, -1000, 5000),
            'total_supply'          => $faker->randomFloat(20, -1000, 5000),
            'percent_change_1h'     => $faker->randomFloat(3, -100, 100),
            'percent_change_24h'    => $faker->randomFloat(3, -100, 100),
            'percent_change_7d'     => $faker->randomFloat(3, -100, 100),
    ];
});
