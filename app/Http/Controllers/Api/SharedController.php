<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SharedController extends Controller
{
    //
    public function status(){
        return response()->json([
            
        ], 200);
    }
}
