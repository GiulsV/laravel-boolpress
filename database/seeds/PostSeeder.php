<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class PostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $categories_ids = Category::all()->pluck('id');
        $users_ids = User::all()->pluck('id');

        // [
        //     [
        //         'id' => 5,
        //         'name'  => 'User1'
        //     ],
        //     [
        //         'id' => 1,
        //         'name'  => 'User2'
        //     ],
        //     [
        //         'id' => 2,
        //         'name'  => 'User3'
        //     ]
        // ]

        // il pluck torna questo: [5, 1, 2]

        for ($i = 0; $i < 150; $i++) {
            $post = new Post;
            $post->user_id = $faker->randomElement($users_ids);
            $post->title = $faker->words(rand(2, 4), true);
            $post->category_id = $faker->randomElement($categories_ids);
            // $post->title = 'ciao a tutti!@';
            $post->slug = Post::getSlug($post->title);
            // $post->image = 'https://picsum.photos/id/' . rand(1, 300) . '/500/300';

            // si può fare anche in altri modi
            $number = rand(0, 276);
            if ($number) {
                $contents = new File(__DIR__ . '/../../storage/app/lorempicsum/picsum (' . $number . ').jpg');
                // $tmp_img_url = $faker->image();
                $post->image = Storage::put('uploads', $contents);
            } else {
                $post->image = null;
            }

            $post->content = $faker->paragraphs(rand(2, 10), true);
            $post->excerpt = $faker->paragraph();
            $post->save();
        }
    }
}
