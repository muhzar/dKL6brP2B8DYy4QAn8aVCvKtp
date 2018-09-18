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
        $data['schedules'] = Schedule::where('assign_date', date('Y-m-d'))->get();
        return view('backend.home', $data);
    }
    
}
