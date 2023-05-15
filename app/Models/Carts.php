<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $table = 'da5_carts';

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function cartDetails()
    {
        return $this->hasMany(Carts_details::class,'cart_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Cần có những trường bắt buộc phải thay đổi
    protected $fillable = [
        'customer_id',
        'total_money',
        'voucher_id',
        'discounted_price',
        'real_money'
    ];
}
