<?php

namespace App\Http\Controllers\Backend;

use App\Live;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        if($request->input('keyword') == '') 
        {
            $data['keyword'] = '';
            $data['users'] = Live::paginate(config('app.record_per_page'));
        } 
        else 
        {
            $data['keyword'] = $request->input('keyword');
            $data['users'] = Live::search($request->input('keyword'))->paginate(config('app.record_per_page'));
        }

        $data['title'] = $this->getTitle();
        
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        
        $data['i'] = $number;
        return view('backend.live.dashboard', $data);
    }

}
