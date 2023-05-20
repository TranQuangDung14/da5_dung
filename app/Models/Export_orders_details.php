<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export_orders_details extends Model
{
    use HasFactory;
    protected $table='da5_export_order_details';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function exportOrder()
    {
        return $this->belongsTo(Export_orders::class, 'export_order_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'export_order_id',
        'product_id',
        'quantity',
        'price',
    ];
}
