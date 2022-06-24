<?php

use Illuminate\Database\Seeder;

use App\Models\Post;

use Faker\Generator as Faker;

use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //
        for ($i=0; $i < 10; $i++) { 

            $new_post = new Post();

            $new_post->title = $faker->sentence(4);

            //slug here
            $new_post->slug = Str::slug($new_post->title, '-');

            $new_post->image = $faker->imageUrl(600, 400, true, $new_post->slug, true);

            $new_post->content = $faker->text(400);

            $new_post->date = $faker->date('Y-m-d', 'now');

            $new_post->save();
        }
    }
}
