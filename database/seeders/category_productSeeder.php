<?php

namespace Database\Seeders;

use App\Models\Category_product;
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
    }
}
