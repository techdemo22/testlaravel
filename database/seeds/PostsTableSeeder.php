<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            factory(Post::class, 5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
