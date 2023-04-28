<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import_orders extends Model
{
    use HasFactory;
    protected $table='da5_import_orders';

    public function import_orders_details()
    {
        return $this->hasOne(Import_orders_details::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'total_quantity',

    ];

}
