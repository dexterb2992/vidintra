<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\VideoIntro;

class VideoIntrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Factory::create();

        VideoIntro::truncate();

        foreach (range(1, 10) as $i) {
            VideoIntro::create([
                'user_id' => 1,
                'name' => str_slug(str_random(10)),
                'video_source' => '',
                'youtube_id' => 'UFeSWGl_34U',
                'action_after_end' => 'redirect', //redirect or loop
                'url_to_rewrite' => '',
                'url_to_redirect' => '',
                'logo_img' => '',
                'skipintro_is_enabled' => 1,
                'skipintro_text' => $faker->sentence
            ]);
        }
    }
}
