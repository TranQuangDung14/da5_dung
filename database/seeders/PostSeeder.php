<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post                                   = new Posts();
        $post->id                               = 1;
        $post->type_post_id                     = 1;
        $post->staff_id                         = 1;
        $post->title                            = 'Bài viết số 1';
        $post->hashtag                          = "200000";
        $post->image                            = 'image/posts/WPV2DvcmEs4L7dqMftbKvQceQRRcmOzHGaLhxkNE.jpg';
        $post->content                          = 'nội dung đó';
        $post->status                           = 1;
        $post->save();


        $post                                   = new Posts();
        $post->id                               = 2;
        $post->type_post_id                     = 1;
        $post->staff_id                         = 1;
        $post->title                            = 'Bài viết số 2';
        $post->hashtag                          = "hastag";
        $post->image                            = 'image/posts/kdhOLKHhYPOtruC3UMXABV9iZAvxig0p39pUolHi.png';
        $post->content                          = 'nội dung đó';
        $post->status                           = 1;
        $post->save();



        $post                                   = new Posts();
        $post->id                               = 3;
        $post->type_post_id                     = 2;
        $post->staff_id                         = 1;
        $post->title                            = 'Bài viết số 3';
        $post->hashtag                          = "dd";
        $post->image                            = 'image/posts/8NhGG1Fm6Fi2Tfx9JzKqxcP2woLjAPb2RfudACw7.jpg';
        $post->content                          = 'nội dung đó';
        $post->status                           = 1;
        $post->save();
    }
}
