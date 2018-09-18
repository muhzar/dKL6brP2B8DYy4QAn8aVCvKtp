<?php

namespace App\Http\Controllers\Backend;

use App\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class RouteController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();
        $data['clusters'] = Cluster::orderBy('name','asc')->get();
        return view('backend.route.route', $data);
    }

    
}
