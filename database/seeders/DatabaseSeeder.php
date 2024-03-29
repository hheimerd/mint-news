<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public $categories = [
        'Кино',
        'Музыка',
        'Игры',
        'Наука',
        'Исскуство',
        'Космос',
        'Путешествия',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            User::factory()
                ->count(5)
                ->has(Post::factory()->count(3)
                    ->count(4))
                ->create();

            foreach ($this->categories as $category) {
                Category::create([
                    'name' => $category
                ]);
            }

            $posts = Post::all();
            foreach ($posts as $post) {
                $categories = Category::inRandomOrder()->limit(3)->get();
                $post->categories()->attach($categories);
                $post->save();
            }
        });
    }
}
