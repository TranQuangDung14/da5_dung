<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='da5_order';

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'payment_method',
        'total_money',
        'delivery_date',
        'shipping_fee',
        'receiver_name',
        'receiver_address',
        'ward_id',
        'districts_id',
        'provinces_id',
        'status',
    ];
}
