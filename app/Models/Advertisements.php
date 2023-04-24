<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisements extends Model
{
    // Quảng cáo
    use HasFactory;
    protected $table='da5_advertisements';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'ordinal',
        'status',
    ];
}
