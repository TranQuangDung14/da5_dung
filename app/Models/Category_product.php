<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    use HasFactory;
    protected $table='da5_category_product';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'product_supplier_id',
        'warehouse_id',
        'status',
    ];
}
