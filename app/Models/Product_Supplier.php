<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Supplier extends Model
{
    use HasFactory;
    protected $table='da5_product_supplier';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'info_supplier_id',
        'name',
        'amount',
        'weight',
        'price',
        'description',
        'status',
    ];
}
