<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class LogController extends Controller
{
    protected $redirectTo = '/cms';
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {   
        $data['title'] = $this->getTitle();
        $data['keyword'] = '';
        $data['posts'] = Log::paginate(config('app.record_per_page'));
        if ($request->input('page') != '' && $request->input('page') != 1) {
            $number = ($request->input('page') -1) * config('app.record_per_page') + 1;
        } else {
            $number = 1;
        }
        $data['i'] = $number;
        return view('backend.log.list', $data);
    }


}
