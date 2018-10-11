<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Schedule;

class IndexController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        return view('backend.home');
    }
    
}
