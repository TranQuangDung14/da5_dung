<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info_Supplier extends Model
{
    use HasFactory;
    protected $table='da5_info_supplier';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'adress',
        'number_phone',
        'status',
    ];
}
