<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import_orders_details extends Model
{
    use HasFactory;
    protected $table='da5_import_orders_detail';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'import_order_id',
        'product_id',
        'quantity',
        'price',
    ];
}
