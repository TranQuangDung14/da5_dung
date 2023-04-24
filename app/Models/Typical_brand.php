<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typical_brand extends Model
{
    // thương hiệu tiêu biểu
    use HasFactory;
    protected $table='da5_typical_brand';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'status',
    ];
}
