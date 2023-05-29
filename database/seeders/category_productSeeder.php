<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category_product;
use App\Models\Store_information;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class category_productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('da5_category_product')->insert(
        //     [
        //         "id"=>"1",
        //         "name"=>'Hoa quả'

        //     ]
        //     );

        $category                                   = new Category_product();
        $category->id                               = 1;
        $category->name                             = 'Danh mục sản phẩm 1';
        $category->status                           = 1;
        $category->save();

        $category                                   = new Category_product();
        $category->id                               = 2;
        $category->name                             = 'Danh mục sản phẩm 2';
        $category->status                           = 1;
        $category->save();

        // $category                                   = new Category_product();
        // $category->id                               = 3;
        // $category->name                             = 'Đồ uống';
        // $category->product_supplier_id              = 1;
        // $category->status                           = 1;
        // $category->save();

        // $category                                   = new Category_product();
        // $category->id                               = 4;
        // $category->name                             = 'Thức ăn';
        // $category->product_supplier_id              = 1;
        // $category->status                           = 1;
        // $category->save();

        // "map":"aa333a",
        // "number_phone":122822828,
        // "email":"email@gmail.com",
        // "open_time":"2001-4-4",
        // "address":"3333"

        $store_information                              = new Store_information();
        $store_information->map                         = "map";
        $store_information->number_phone                = '0869 638 364';
        $store_information->email                       = "quangstsdung@gmail.com";
        $store_information->open_time                   = "mở cửa từ 8h sáng đến 19h hằng ngày";
        $store_information->address                     = "Đoàn Đào - Phù Cừ -Hưng Yên";
        $store_information->status                      = 1;
        $store_information->save();


        $banner                              = new Banner();
        $banner->image                       = "image/posts/5PfvCqt28f5sTSWt1m8EAPsmmO21HyyjfcJPgPUT.jpg";
        $banner->ordinal                     = 1;
        $banner->status                      = 1;
        $banner->save();
        $banner                              = new Banner();
        $banner->image                       = "image/posts/9siVwuRFJeUbMiH07J19WzFXaMYzsGDx9nUWvItk.png";
        $banner->ordinal                     = 2;
        $banner->status                      = 1;
        $banner->save();
        $banner                              = new Banner();
        $banner->image                       = "image/posts/LocepnjB499fbigwQsX2RQvITw5ccjkmopXNhKOd.jpg";
        $banner->ordinal                     = 3;
        $banner->status                      = 1;
        $banner->save();
        $banner                              = new Banner();
        $banner->image                       = "image/posts/gc29RC3T9i6csiTNyf02LzJ0RJEQsQsAYmbZPhQm.png";
        $banner->ordinal                     = 4;
        $banner->status                      = 1;
        $banner->save();
    }
}
