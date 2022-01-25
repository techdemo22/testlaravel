<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->realText,
        'is_draft' => 0,
        'is_members_only' => 0,
        'posted_at' => $faker->dateTime,
    ];
});
