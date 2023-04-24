<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts_details extends Model
{
    use HasFactory;
    protected $table='da5_cart_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Cần có những trường bắt buộc phải thay đổi
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'discout',
    ];
}
