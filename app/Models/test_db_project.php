<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class test_db_project extends Model
{
    use HasFactory;
    protected $table = "test_db_project";


        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'number_phone',
        'email',
        'adress',
        'testdb1_id',
    ];
}
