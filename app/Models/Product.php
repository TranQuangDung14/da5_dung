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
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'default_price',
        'price',
        'description',
        'status',
    ];
}
