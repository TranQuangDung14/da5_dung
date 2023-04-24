<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='da5_order';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'payment_method',
        'export_order_id',
        'delivery_date',
        'shipping_fee',
        'receiver_name',
        'receiver_address',
        'status',
    ];
}
