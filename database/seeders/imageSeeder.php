<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class imageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image                                  = new Image();
        $image->id                              = 1;
        $image->image                           = "1683519623-choxujpg.jpg";
        $image->product_id                      = 1;
        $image->save();


        $image                                  = new Image();
        $image->id                              = 2;
        $image->image                           = "1683528121-screenshot-2png.png";
        $image->product_id                      = 2;
        $image->save();


        $image                                  = new Image();
        $image->id                              = 3;
        $image->image                           = "1683528121-screenshot-4png.png";
        $image->product_id                      = 3;
        $image->save();


        $image                                  = new Image();
        $image->id                              = 4;
        $image->image                           = "1681227988-back6jpg.jpg";
        $image->product_id                      = 4;
        $image->save();


        $image                                  = new Image();
        $image->id                              = 5;
        $image->image                           = "1683303172-stmtpjpg.jpg";
        $image->product_id                      = 4;
        $image->save();


        $image                                  = new Image();
        $image->id                              = 6;
        $image->image                           = "1683303172-stmtpjpg.jpg";
        $image->product_id                      = 5;
        $image->save();
    }
}
