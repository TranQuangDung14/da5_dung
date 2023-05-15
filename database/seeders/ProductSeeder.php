<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product                                   = new Product();
        $product->id                               = 1;
        $product->category_id                      = 1;
        $product->brand_id                         = 1;
        $product->name                             = 'Sản phẩm số 1';
        $product->default_price                    = 200000;
        $product->description                      = 'Mô tả';
        $product->tech_specs                       = 'Thông số kĩ thuật';
        $product->quantity                         = 12;
        $product->status                           = 1;
        $product->save();


        $product                                   = new Product();
        $product->id                               = 2;
        $product->category_id                      = 1;
        $product->brand_id                         = 1;
        $product->name                             = 'Sản phẩm số 2';
        $product->default_price                    = 300000;
        $product->description                      = 'Mô tả';
        $product->tech_specs                       = 'Thông số kĩ thuật';
        $product->quantity                         = 13;
        $product->status                           = 1;
        $product->save();


        $product                                   = new Product();
        $product->id                               = 3;
        $product->category_id                      = 1;
        $product->brand_id                         = 1;
        $product->name                             = 'Sản phẩm số 3';
        $product->default_price                    = 400000;
        $product->description                      = 'Mô tả';
        $product->tech_specs                       = 'Thông số kĩ thuật';
        $product->quantity                         = 14;
        $product->status                           = 1;
        $product->save();

        $product                                   = new Product();
        $product->id                               = 4;
        $product->category_id                      = 1;
        $product->brand_id                         = 1;
        $product->name                             = 'Sản phẩm số 4';
        $product->default_price                    = 200000;
        $product->description                      = 'Mô tả';
        $product->tech_specs                       = 'Thông số kĩ thuật';
        $product->quantity                         = 15;
        $product->status                           = 1;
        $product->save();

        $product                                   = new Product();
        $product->id                               = 5;
        $product->category_id                      = 2;
        $product->brand_id                         = 1;
        $product->name                             = 'Sản phẩm số 5';
        $product->default_price                    = 200000;
        $product->description                      = 'Mô tả';
        $product->tech_specs                       = 'Thông số kĩ thuật';
        $product->quantity                         = 10;
        $product->status                           = 1;
        $product->save();

        // voucher
        $code                                   = new Voucher();
        $code->id                               = 1;
        $code->code                             = "VCID1";
        $code->discount_percentage              = 2.5;
        $code->start_date                       = "2023-05-06 15:28:00";
        $code->end_date                         = "2023-06-04 15:28:00";
        $code->save();


        $code                                   = new Voucher();
        $code->id                               = 2;
        $code->code                             = "VCID2";
        $code->discount_percentage              = 20;
        $code->start_date                       = "2023-05-06 15:28:00";
        $code->end_date                         = "2023-06-04 15:28:00";
        $code->save();


    }
}
