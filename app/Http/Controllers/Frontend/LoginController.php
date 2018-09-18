<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Post;

class LoginController extends IndexController
{

    public function __construct()
    {
        
    }

    public function index()
    {
    	return response()->json([
		    'status' => 'true',
		    'uid' => '001'
		]);
    }
    
}
