<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table='da5_staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Cần có những trường bắt buộc phải thay đổi
    protected $fillable = [
        'name',
        'user_id',
        'date_of_birth',
        'sex',
        'number_phone',
        'email',
        'adress',
        'possion',
        'department',
    ];

}
