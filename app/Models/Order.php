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
        // return $this->hasMany(Orders_details::class);
        return $this->hasMany(Orders_details::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'code_order',
        'payment_method',
        'total_money',
        'delivery_date',
        'shipping_fee',
        'receiver_name',
        'number_phone',
        'receiver_address',
        'ward_id',
        'districts_id',
        'provinces_id',
        'status',
    ];
}
