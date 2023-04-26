<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table='da5_video';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_video_id',
        'staff_id',
        'title',
        'video',
        'link_id',
        'hashtag',
        'description',
        'status',
    ];
}
