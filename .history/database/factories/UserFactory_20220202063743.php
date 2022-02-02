<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

//factory(App\User::class, 500)->create();
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => Str::slug($faker->name),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'role' => rand(1, 5),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
