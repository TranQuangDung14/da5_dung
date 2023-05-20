<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export_orders extends Model
{
    use HasFactory;
    protected $table='da5_export_orders';

    public function export_orders_details()
    {
        return $this->hasMany(Export_orders_details::class,'export_order_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'total_quantity',
    ];
}
