<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store_information extends Model
{
    use HasFactory;
    protected $table='da5_store_information';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'map',
        'number_phone',
        'email',
        'status',
    ];
}
