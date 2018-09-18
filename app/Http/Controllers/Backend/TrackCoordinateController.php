<?php

namespace App\Http\Controllers\Backend;

use App\Guard;
use App\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;
use Redirect;
use Auth;
use Validator;
use Hash;

class TrackCoordinateController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function setByMap() {
        $data['title'] = $this->getTitle();
        $data['clusters'] = Cluster::orderBy('name','asc')->get();
        return view('backend.cluster.map', $data);
    }
    
}
