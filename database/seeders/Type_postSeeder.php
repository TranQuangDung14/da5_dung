<?php

namespace Database\Seeders;

use App\Models\Type_Posts;
use Illuminate\Database\Seeder;

class Type_postSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_post                              = new Type_Posts();
        $type_post->id                          = 1;
        $type_post->name                        = "Danh mục bài viết 1";
        $type_post->status                      = 1;
        $type_post->save();


        $type_post                              = new Type_Posts();
        $type_post->id                          = 2;
        $type_post->name                        = "Danh mục bài viết 2";
        $type_post->status                      = 1;
        $type_post->save();

    }
}
