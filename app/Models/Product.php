<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='da5_product';

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }
    public function category()
    {
        return $this->belongsTo(Category_product::class);
    }
    public function cartDetails()
    {
        return $this->hasMany(Carts_details::class,'product_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'category_id',
        'brand_id',
        'name',
        'default_price',
        // 'price',
        'description',
        'tech_specs',
        'hashtag',
        'quantity',
        'status',
    ];
}
