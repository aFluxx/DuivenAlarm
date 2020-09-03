<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => 'De Belser Arne',
        'email' => 'debelserarne@hotmail.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$q5PLPLDORzdD3ZFZru5mgO9ka4UMr62i//guaIGuHuSbRbFhO.oDa', // secret
        'api_token' => 'YdCoenzt6oncuokC6qNtrHLriENX6qM10nJdOlUsyxPjejwtjY9aK8o85vvX',
    ];
});
